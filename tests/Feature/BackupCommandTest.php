<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BackupCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_sqlite_backup_writes_an_artefact_to_the_target_disk(): void
    {
        Storage::fake('local');

        // RefreshDatabase uses an in-memory SQLite for tests, which has
        // no on-disk path — point the backup at the schema.sqlite that
        // Laravel publishes for `php artisan migrate` so the copy step
        // has something to consume.
        $tmpDb = tempnam(sys_get_temp_dir(), 'clinic-backup-');
        if ($tmpDb !== false) {
            file_put_contents($tmpDb, "fake-sqlite-bytes\n");
            config()->set('database.connections.sqlite.database', $tmpDb);
        }

        $this->artisan('db:backup', ['--disk' => 'local', '--prefix' => 'backups-test'])
            ->assertSuccessful();

        $files = Storage::disk('local')->files('backups-test');
        $this->assertNotEmpty($files);
        $this->assertStringEndsWith('.sqlite', $files[0]);

        if (isset($tmpDb) && $tmpDb !== false) {
            @unlink($tmpDb);
        }
    }
}
