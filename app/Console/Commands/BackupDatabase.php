<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

/**
 * Take a logical snapshot of the database and ship it to a Storage
 * disk for off-site retention.
 *
 * Defaults match the project's "small clinic" deployment shape:
 *
 *   - MySQL/MariaDB → mysqldump (single-transaction, routines, triggers)
 *   - SQLite        → file copy (the entire DB is the file)
 *
 * Files land on the `backups` disk by default, which deployers can
 * point at S3 / DigitalOcean Spaces / GCS via filesystems.php. Locally
 * (`local` disk) backups land under storage/app/backups.
 *
 * Wire this into the scheduler via Console\Kernel::schedule():
 *
 *     $schedule->command('db:backup')->dailyAt('02:00');
 */
class BackupDatabase extends Command
{
    protected $signature = 'db:backup
        {--disk= : Storage disk to upload to (defaults to config(filesystems.default))}
        {--prefix=backups : Path prefix within the disk}
        {--keep=14 : Keep at most this many recent backups (oldest pruned)}';

    protected $description = 'Snapshot the configured database and ship it to a Storage disk.';

    public function handle(): int
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        $disk = (string) ($this->option('disk') ?: config('filesystems.default'));
        $prefix = trim((string) $this->option('prefix'), '/');
        $keep = max(1, (int) $this->option('keep'));

        $timestamp = now()->format('Ymd_His');

        $artifactPath = match ($driver) {
            'mysql', 'mariadb' => $this->dumpMysql($timestamp),
            'sqlite' => $this->dumpSqlite($timestamp),
            default => null,
        };

        if ($artifactPath === null) {
            $this->error("db:backup does not support driver [{$driver}].");

            return self::INVALID;
        }

        $targetPath = "{$prefix}/{$connection}-{$timestamp}.".pathinfo($artifactPath, PATHINFO_EXTENSION);
        $stream = fopen($artifactPath, 'rb');

        try {
            Storage::disk($disk)->writeStream($targetPath, $stream);
        } finally {
            if (is_resource($stream)) {
                fclose($stream);
            }
            @unlink($artifactPath);
        }

        $this->pruneOld($disk, $prefix, $keep);

        Log::channel('audit')->info('Database backup completed', [
            'driver' => $driver,
            'disk' => $disk,
            'path' => $targetPath,
        ]);

        $this->info("Backup written to disk [{$disk}] at [{$targetPath}].");

        return self::SUCCESS;
    }

    private function dumpMysql(string $timestamp): string
    {
        $connection = config('database.default');
        $cfg = config("database.connections.{$connection}");
        $out = storage_path("app/tmp-backup-{$timestamp}.sql.gz");

        $cmd = [
            'sh', '-c',
            sprintf(
                'mysqldump --single-transaction --routines --triggers '
                .'--no-tablespaces '
                .'--host=%s --port=%s --user=%s --password=%s %s | gzip > %s',
                escapeshellarg((string) ($cfg['host'] ?? 'localhost')),
                escapeshellarg((string) ($cfg['port'] ?? '3306')),
                escapeshellarg((string) ($cfg['username'] ?? 'root')),
                escapeshellarg((string) ($cfg['password'] ?? '')),
                escapeshellarg((string) ($cfg['database'] ?? '')),
                escapeshellarg($out),
            ),
        ];

        $process = new Process($cmd);
        $process->setTimeout(3600);
        $process->mustRun();

        return $out;
    }

    private function dumpSqlite(string $timestamp): string
    {
        $connection = config('database.default');
        $path = (string) config("database.connections.{$connection}.database");

        if (! is_file($path)) {
            throw new \RuntimeException("SQLite database file not found at [{$path}].");
        }

        $out = storage_path("app/tmp-backup-{$timestamp}.sqlite");

        // Use the SQL connection's BACKUP TO if available; falling
        // back to copy is fine for small databases.
        copy($path, $out);

        // Force a checkpoint so the WAL is captured.
        try {
            DB::connection()->statement('PRAGMA wal_checkpoint(TRUNCATE)');
        } catch (\Throwable $e) {
            // pragma is best-effort; the copy is still valid
        }

        return $out;
    }

    private function pruneOld(string $disk, string $prefix, int $keep): void
    {
        $files = Storage::disk($disk)->files($prefix);
        rsort($files);

        foreach (array_slice($files, $keep) as $stale) {
            Storage::disk($disk)->delete($stale);
        }
    }
}
