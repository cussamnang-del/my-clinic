<?php

namespace App\Providers;

use App\Services\RequestContext;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Singleton: the per-request id should be the same everywhere
        // we resolve RequestContext during a single HTTP request.
        $this->app->singleton(RequestContext::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerSlowQueryLogging();
        $this->registerFailedJobLogging();
    }

    /**
     * Log queries that exceed `observability.slow_query_ms` (default 500ms)
     * onto a dedicated channel. Disabled by default in non-prod via the
     * config flag, so test/dev runs don't get spammed.
     */
    private function registerSlowQueryLogging(): void
    {
        if (! config('observability.slow_queries.enabled', false)) {
            return;
        }

        $threshold = (int) config('observability.slow_queries.threshold_ms', 500);
        $channel = (string) config('observability.slow_queries.channel', 'slow_query');

        DB::listen(function (QueryExecuted $event) use ($threshold, $channel): void {
            if ($event->time < $threshold) {
                return;
            }

            Log::channel($channel)->warning('Slow query detected', [
                'sql' => $event->sql,
                'time_ms' => round($event->time, 2),
                'connection' => $event->connectionName,
            ]);
        });
    }

    /**
     * Persist every failed job to the dedicated `failed_jobs` channel.
     * Laravel already writes them to the `failed_jobs` DB table, but a
     * file channel survives DB outages and is easier to ship to
     * external log aggregators.
     */
    private function registerFailedJobLogging(): void
    {
        $channel = (string) env('LOG_FAILED_JOBS_CHANNEL', 'failed_jobs');

        Queue::failing(function (JobFailed $event) use ($channel): void {
            Log::channel($channel)->error('Queue job failed', [
                'connection' => $event->connectionName,
                'job' => $event->job->resolveName(),
                'exception' => $event->exception->getMessage(),
                'trace' => $event->exception->getTraceAsString(),
            ]);
        });
    }
}
