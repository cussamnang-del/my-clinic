<?php

namespace Tests\Feature;

use App\Http\Middleware\AttachRequestContext;
use App\Services\RequestContext;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class RequestContextTest extends TestCase
{
    public function test_generated_request_id_is_attached_to_the_response_when_no_header_is_sent(): void
    {
        $middleware = app(AttachRequestContext::class);
        $request = Request::create('/health', 'GET');

        $response = $middleware->handle($request, fn () => new Response('ok', 200));

        $this->assertNotEmpty($response->headers->get('X-Request-Id'));
        // The middleware also seeds the singleton — they must agree.
        $this->assertSame(
            $response->headers->get('X-Request-Id'),
            app(RequestContext::class)->requestId(),
        );
    }

    public function test_upstream_request_id_header_is_honoured(): void
    {
        $middleware = app(AttachRequestContext::class);
        $request = Request::create('/health', 'GET');
        $request->headers->set('X-Request-Id', 'upstream-abc-123');

        $response = $middleware->handle($request, fn () => new Response('ok', 200));

        $this->assertSame('upstream-abc-123', $response->headers->get('X-Request-Id'));
        $this->assertSame('upstream-abc-123', app(RequestContext::class)->requestId());
    }

    public function test_overlong_upstream_id_is_rejected_in_favour_of_a_generated_one(): void
    {
        $middleware = app(AttachRequestContext::class);
        $request = Request::create('/health', 'GET');
        $request->headers->set('X-Request-Id', str_repeat('a', 65));

        $response = $middleware->handle($request, fn () => new Response('ok', 200));

        $emitted = $response->headers->get('X-Request-Id');
        $this->assertNotSame(str_repeat('a', 65), $emitted);
        $this->assertNotEmpty($emitted);
    }
}
