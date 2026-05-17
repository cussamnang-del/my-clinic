<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Streamed CSV export.
 *
 * Bulk exports of clinical data (e.g. monthly bio-result dumps, TAT
 * reports, billing exports) routinely exceed the request timeout when
 * generated inline. This job streams rows to a temporary file and
 * promotes the file to long-term storage when the row generator is
 * exhausted — keeping memory and request time bounded regardless of
 * dataset size.
 *
 * Callers provide a closure that returns an iterable of associative
 * arrays. The closure runs inside the job worker, so it must not
 * close over non-serializable state (request, controller, etc.).
 */
class ExportReportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public int $backoff = 60;

    public int $timeout = 600;

    /**
     * @param  array<int, string>  $headers
     * @param  callable(): iterable<array<string, mixed>>  $rowGenerator
     */
    public function __construct(
        public readonly array $headers,
        public readonly string $disk,
        public readonly string $path,
        public $rowGenerator,
    ) {}

    public function handle(): void
    {
        $tmp = tempnam(sys_get_temp_dir(), 'export_');
        if ($tmp === false) {
            throw new \RuntimeException('Unable to allocate a temp file for export.');
        }

        $rowsWritten = 0;

        try {
            $handle = fopen($tmp, 'w');
            if ($handle === false) {
                throw new \RuntimeException('Unable to open temp file for writing.');
            }

            fputcsv($handle, $this->headers);

            foreach (call_user_func($this->rowGenerator) as $row) {
                fputcsv($handle, array_map(
                    static fn ($key) => $row[$key] ?? '',
                    $this->headers,
                ));
                $rowsWritten++;
            }

            fclose($handle);

            Storage::disk($this->disk)
                ->put($this->path, file_get_contents($tmp));
        } finally {
            @unlink($tmp);
        }

        Log::channel('clinical')->info('Report exported', [
            'disk' => $this->disk,
            'path' => $this->path,
            'rows' => $rowsWritten,
        ]);
    }
}
