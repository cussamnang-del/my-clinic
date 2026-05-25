<?php

/**
 * Observability configuration.
 *
 * Keeps log-related toggles in one place so we can flip them per-env
 * without touching the codebase. The defaults are conservative —
 * everything that costs CPU or disk in hot paths is opt-in.
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Slow-query logging
    |--------------------------------------------------------------------------
    |
    | When enabled, queries that take longer than `threshold_ms` are logged
    | to the configured channel. Defaults match what we use in production:
    | 500ms is well above normal Eloquent traffic but well below the point
    | where users notice latency, so anything that trips it is worth a look.
    |
    */
    'slow_queries' => [
        'enabled' => env('OBSERVABILITY_SLOW_QUERIES_ENABLED', false),
        'threshold_ms' => env('OBSERVABILITY_SLOW_QUERY_THRESHOLD_MS', 500),
        'channel' => env('OBSERVABILITY_SLOW_QUERY_CHANNEL', 'slow_query'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit & clinical channels
    |--------------------------------------------------------------------------
    |
    | The `audit` channel is where the ActivityLogService writes structured
    | events; `clinical` is intended for high-level domain events
    | (result released, document amended, …). Both default to a daily
    | file driver so we keep meaningful retention.
    |
    */
    'channels' => [
        'audit' => env('OBSERVABILITY_AUDIT_CHANNEL', 'audit'),
        'clinical' => env('OBSERVABILITY_CLINICAL_CHANNEL', 'clinical'),
    ],

    /*
    |--------------------------------------------------------------------------
    | TAT (Turn-Around Time) target
    |--------------------------------------------------------------------------
    |
    | Default lab-wide TAT target in minutes used by TatKpiService when the
    | individual test row does not specify one. ISO 15189:2022 §7.4.1
    | requires labs to define & monitor TAT — flip via env so the
    | clinical lead can tune it without a code change.
    |
    */
    'tat_target_minutes' => env('TAT_TARGET_MINUTES', 240),

];
