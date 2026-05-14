<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Force HTTPS on every request when running outside the `local` environment.
 *
 * This protects against accidental HTTP requests in staging / production
 * where TLS is expected but a misconfigured load-balancer might still
 * forward plain HTTP. In `local` / `testing` it is a no-op so dev servers
 * continue to work over plain HTTP.
 */
class ForceHttpsInProduction
{
  public function handle(Request $request, Closure $next): Response
  {
    if (!$request->isSecure() && !app()->environment(['local', 'testing'])) {
      return redirect()->secure($request->getRequestUri(), 301);
    }

    return $next($request);
  }
}
