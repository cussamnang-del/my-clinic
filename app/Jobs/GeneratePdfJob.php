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
 * Background PDF render.
 *
 * The legacy controllers render PDFs synchronously inside the
 * HTTP request, which (a) blocks the user for seconds and (b)
 * occasionally times out behind a slow upstream. This job is the
 * skeleton that lets controllers fire-and-forget a render and then
 * download the file from a known location when it's ready.
 *
 * The actual rendering backend (DOM-to-PDF, headless Chrome, etc.)
 * is intentionally not chosen here — `handle()` writes a placeholder
 * blob via the `Storage` facade so we have an integration point. Wire
 * a real renderer up by replacing the body of `handle()` with whatever
 * library the team standardises on.
 */
class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct(
        public readonly string $view,
        public readonly array $payload,
        public readonly string $disk,
        public readonly string $path,
    ) {}

    public function handle(): void
    {
        $this->bootstrapForJob();

        $contents = $this->render();

        Storage::disk($this->disk)->put($this->path, $contents);

        Log::channel('clinical')->info('PDF generated', [
            'view' => $this->view,
            'disk' => $this->disk,
            'path' => $this->path,
            'size' => strlen($contents),
        ]);
    }

    /**
     * Override in tests via a child class to swap the renderer.
     */
    protected function render(): string
    {
        return view($this->view, $this->payload)->render();
    }

    private function bootstrapForJob(): void
    {
        Log::withContext([
            'job' => static::class,
            'queue' => $this->queue ?? 'default',
        ]);
    }
}
