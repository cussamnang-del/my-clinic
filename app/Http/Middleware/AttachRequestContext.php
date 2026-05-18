<?php

namespace App\Http\Middleware;

use App\Services\RequestContext;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Attaches a stable request id + user id to every log line for the
 * lifetime of the request. This is the single piece of plumbing
 * needed to make the application's logs investigable in production —
 * without a correlation id, tracing a clinical action across multiple
 * log lines is effectively impossible.
 *
 * If a trusted upstream (e.g. a load balancer) already issues an
 * `X-Request-Id` header we adopt it; otherwise we generate a UUID.
 *
 * The header is echoed back on the response so the operator who saw
 * the request fail has the same id the logs are tagged with.
 */
class AttachRequestContext
{
    public function __construct(private readonly RequestContext $context) {}

    public function handle(Request $request, Closure $next)
    {
        $incoming = trim((string) $request->headers->get('X-Request-Id', ''));
        $requestId = $incoming !== '' && strlen($incoming) <= 64
            ? $incoming
            : (string) Str::uuid();

        $this->context->setRequestId($requestId);

        Log::withContext([
            'request_id' => $requestId,
            'user_id' => Auth::id(),
            'route' => optional($request->route())->getName(),
            'method' => $request->getMethod(),
            'path' => $request->path(),
            'ip' => $request->ip(),
        ]);

        $response = $next($request);

        if (method_exists($response, 'header')) {
            $response->header('X-Request-Id', $requestId);
        } elseif (isset($response->headers)) {
            $response->headers->set('X-Request-Id', $requestId);
        }

        return $response;
    }
}
