<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
  /**
   * The path to the "home" route for your application.
   *
   * Typically, users are redirected here after authentication.
   *
   * @var string
   */
  public const HOME = '/admin/documents';

  /**
   * Define your route model bindings, pattern filters, and other route
   * configuration.
   */
  public function boot(): void
  {
    $this->configureRateLimiting();

    $this->routes(function () {
      Route::middleware('api')
        ->prefix('api')
        ->group(base_path('routes/api.php'));

      Route::middleware('web')
        ->group(base_path('routes/web.php'));

      Route::middleware('web')
        ->group(base_path('routes/admin.php'));
    });
  }

  /**
   * Configure the rate limiters for the application.
   *
   * Named limiters can be referenced from routes as e.g.
   * `Route::middleware('throttle:login')`.
   *
   * Maps to:
   *   - OWASP ASVS v4 §11.1 (Anti-automation)
   *   - audit-report.md → H-5 "No rate limiting on login / public AJAX endpoints"
   */
  protected function configureRateLimiting(): void
  {
    // Default `api` limiter — used by the `api` middleware group.
    RateLimiter::for('api', function (Request $request) {
      return Limit::perMinute(60)->by(
        optional($request->user())->id ?: $request->ip()
      );
    });

    // Login + password-reset: aggressive throttle on IP + email/username.
    RateLimiter::for('login', function (Request $request) {
      $email = (string) $request->input('email', '');
      return [
        Limit::perMinute(5)->by(strtolower($email) . '|' . $request->ip()),
        Limit::perMinute(20)->by($request->ip()),
      ];
    });

    // Public AJAX endpoints (country / district / commune / village lookup,
    // /home redirect, etc.) — generous but bounded.
    RateLimiter::for('public', function (Request $request) {
      return Limit::perMinute(120)->by($request->ip());
    });

    // Authenticated admin endpoints. Per-user limit is lenient because
    // the document UI fires many AJAX requests per page; the IP limit is
    // a backstop against scripted abuse.
    RateLimiter::for('admin', function (Request $request) {
      return [
        Limit::perMinute(300)->by(
          optional($request->user())->id ?: $request->ip()
        ),
        Limit::perMinute(600)->by($request->ip()),
      ];
    });
  }
}
