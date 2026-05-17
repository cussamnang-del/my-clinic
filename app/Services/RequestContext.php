<?php

namespace App\Services;

use App\Http\Middleware\AttachRequestContext;
use Illuminate\Support\Str;

/**
 * Per-request contextual information shared across log lines, jobs,
 * and outbound HTTP calls. The `request_id` is generated once per
 * incoming request by the {@see AttachRequestContext}
 * middleware and travels through the system as a correlation key.
 *
 * Usage:
 *   app(RequestContext::class)->requestId();
 *   Log::info('something happened', app(RequestContext::class)->forLog());
 */
class RequestContext
{
    private ?string $requestId = null;

    public function setRequestId(string $id): void
    {
        $this->requestId = $id;
    }

    public function requestId(): string
    {
        if ($this->requestId === null) {
            // Generate one lazily so background jobs / console commands
            // still have a stable id to attach to their logs.
            $this->requestId = (string) Str::uuid();
        }

        return $this->requestId;
    }

    /**
     * @return array<string, mixed>
     */
    public function forLog(): array
    {
        return [
            'request_id' => $this->requestId(),
        ];
    }
}
