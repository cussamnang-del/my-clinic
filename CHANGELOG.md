# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

This changelog also serves as evidence of *control of documented information*
required by ISO 9001:2015 §7.5.

---

## [Unreleased]

### Added — Phase 5 (Reporting & dashboards)
- **Quality dashboard.** New `/admin/quality` surface (controller +
  Blade) summarises every Phase 3 ISO module — counts, "needs
  attention" badges (calibration due ≤30d, expiring reagent lots,
  high-score risks, …), plus a 7-day TAT card and shortcuts into
  the QC and result-release worklists.
- **Result-release UI.** `/admin/quality/results` lists pending /
  released / amended results. The detail view renders the e-signature
  form for the next legal transition (submit → review → release) and a
  separate amendment form (value + reason + password) that posts to
  the existing Phase 2 `ResultReleaseController`. All state-machine
  enforcement stays in `ResultReleaseService`; the UI just wires it.
- **TAT KPI service + dashboard.** `App\Services\TatKpiService` computes
  on-time %, mean / median / p90 TAT, per-day released counts, and
  recent breaches (released-slow OR pending past target) over a
  configurable window (today / 7d / 30d). Configurable target via
  `config/observability.php → tat_target_minutes`.
- **QC Levey-Jennings + Westgard rules.** New `qc_results` table,
  `QcResult` model, and `App\Services\QcStatisticsService` evaluating
  1-3s / 2-2s / R-4s (reject) + 1-2s (warning) per ISO 15189:2022
  §7.3.7.2. The chart view renders a server-side SVG Levey-Jennings
  plot with ±1/2/3 SD bands so the chart works without JS.
- **Read-only admin index pages** for Phase 3 modules: SOP / Document
  Control, Equipment & Calibration, Reagent Lots, NCR / CAPA, Risk
  Register, Internal Audits, Training & Competency. Mutations remain
  behind the existing service layer so workflow rules stay enforced.
- **Permissions.** `IsoModulesPermissionSeeder` now also seeds the
  `quality_access` / `qc_result_access` permission set so a "QMS
  reviewer" role can be granted dashboard access without every
  per-module permission.
- **Navigation.** Sidebar gains a single "Quality" menu grouping every
  new page.
- **Tests.** `QcStatisticsTest` (8 cases — every Westgard rule plus
  chart-shape), `TatKpiServiceTest` (summary + pending-breach
  detection), and `QualityDashboardRoutesTest` (route + view-layer
  smoke for 5 surfaces).

### Added — Phase 4 (Operational excellence)
- **Service layer.** New `App\Services\DocumentService` extracts
  Document core CRUD out of the 1,938-LOC `DocumentController`
  god-object. `store()`, `changeStatus()`, and `destroy()` now delegate
  to the service. Behaviour-preserving — wraps `updateOrCreate` in a
  transaction and continues to soft-delete via the Phase 2 trait.
- **API resources** (`App\Http\Resources\*`) — `CustomerResource`,
  `DocumentResource`, `ItemResource`, `ItemTypeResource`. Stable
  JSON shapes for AJAX endpoints so we stop leaking raw model
  columns to the front-end.
- **Queue jobs.**
  - `App\Jobs\GeneratePdfJob` — skeleton for off-request PDF
    rendering. Picks any disk + writes the rendered HTML to it. Logs
    to the `clinical` channel.
  - `App\Jobs\ExportReportJob` — streamed CSV export. Writes via
    `tempnam()` → `Storage::writeStream()` so memory and request
    time stay bounded for large reports.
- **Observability.**
  - `App\Services\RequestContext` — request-scoped singleton holding
    a UUID correlation id (lazy-generated, propagated to logs and
    returned in the `X-Request-Id` response header).
  - `App\Http\Middleware\AttachRequestContext` — global middleware
    that adopts upstream `X-Request-Id` (max 64 chars) or generates a
    new UUID, then `Log::withContext()`s `request_id`, `user_id`,
    `route`, `method`, `path`, `ip` so every log line in a request
    is correlatable.
  - `config/observability.php` — central toggles for slow-query
    capture and per-domain log channels.
  - `config/logging.php` — new `audit` (365d), `clinical` (365d),
    `slow_query` (14d), `failed_jobs` (90d) daily-rotating channels.
  - `AppServiceProvider::registerSlowQueryLogging()` — logs every
    query above `OBSERVABILITY_SLOW_QUERY_THRESHOLD_MS` (500ms
    default) to the `slow_query` channel.
  - `AppServiceProvider::registerFailedJobLogging()` — every
    `Queue::failing` event is mirrored onto the `failed_jobs`
    channel for off-DB log shipping.
- **Backups.**
  - `App\Console\Commands\BackupDatabase` (`php artisan db:backup`) —
    `mysqldump --single-transaction` for MySQL/MariaDB, file copy +
    WAL checkpoint for SQLite. Streams the artefact to a Laravel
    Storage disk and prunes to `--keep=N` (default 14).
  - Scheduled daily at 02:00 in `Console\Kernel` with
    `onOneServer()->withoutOverlapping()`.
  - New `backups` filesystem disk in `config/filesystems.php`,
    pointable at S3/Spaces via `BACKUP_DISK_DRIVER` /
    `BACKUP_DISK_ROOT` env vars.

### Added — tests
- `DocumentServiceTest` — create / update / changeStatus / soft-delete
  invariants of the extracted service.
- `RequestContextTest` — middleware generates IDs, adopts upstream
  ones, rejects oversize headers, and echoes the chosen ID back in
  the response.
- `ApiResourcesTest` — JSON-shape invariants and `whenLoaded()`
  passthrough for nested customer data.
- `ExportReportJobTest` — CSV streaming + missing-key handling.
- `BackupCommandTest` — `db:backup` boots and writes to the target
  disk.
- Suite now 55 tests / 154 assertions, all green.

### Added — Phase 3 (ISO 9001 / ISO 15189 quality modules)
- **Document Control (ISO 9001:2015 §7.5).** New tables
  `sop_documents`, `sop_revisions`, `sop_acknowledgements`. Each SOP
  has an explicit revision history (`draft → submitted → approved →
  effective → superseded`), the document points at the currently
  effective revision, and staff read-receipts are unique per
  (revision × user). New `App\Services\SopReleaseService` enforces
  the state machine, segregation of duties (submitter ≠ approver),
  and atomic supersession of the previous effective revision.
- **Equipment & Calibration (ISO 15189:2022 §6.4–§6.5).** New tables
  `equipment` and `equipment_calibrations`. `Equipment::isCalibrationOverdue()`
  returns `true` once `next_calibration_due_at` is in the past so the
  UI can colour-code overdue assets without per-row work.
- **Reagent Lots (ISO 15189:2022 §6.4.3).** New `reagent_lots` table
  capturing lot #, manufacturer, receipt / open / expiry dates and
  the in-use stability window (`open_use_days_allowed`). The model
  exposes `isShelfExpired`, `isInUseExpired`, and a combined
  `isUsable` helper.
- **NCR & CAPA (ISO 9001:2015 §10.2, ISO 15189:2022 §8.7).** New
  tables `non_conformances` and `capa_actions`. New
  `App\Services\CapaWorkflowService` drives
  `open → in_progress → effectiveness_check → closed` with hard
  constraints — cannot submit for check without `action_taken`,
  cannot close without `verification_evidence` — and automatically
  flips the parent NCR to `closed_with_capa` once every CAPA is
  closed/cancelled.
- **Internal Audits (ISO 9001:2015 §9.2).** New tables
  `internal_audits` and `audit_findings`. Non-conformance findings
  can link directly to an `NonConformance` row, giving the auditor a
  one-click path from finding to CAPA.
- **Training & Competency (ISO 15189:2022 §6.2).** New tables
  `competencies`, `training_records`, `competency_assessments`.
  Competencies carry a `reassessment_interval_months` cadence;
  `CompetencyAssessment::isReassessmentDue()` flags overdue
  re-assessments.
- **Risk Register (ISO 9001:2015 §6.1, ISO 15189:2022 §5.6).** New
  `risks` table with inherent + residual likelihood/severity/score
  columns. New `App\Services\RiskScoringService` enforces the 1–5
  input range and computes scores; `Risk::band()` classifies scores
  as `low` / `medium` / `high` / `extreme` using the standard 5×5
  matrix bands.
- **Permissions.** New `IsoModulesPermissionSeeder` adds
  `<module>_management_access`, `_access`, `_create`, `_edit`,
  `_show`, `_delete` entries for each of the seven new modules.
  Idempotent (uses `firstOrCreate`).
- **Tests.** New `tests/Feature/SopReleaseWorkflowTest`,
  `EquipmentCalibrationTest`, `ReagentLotTest`, `CapaWorkflowTest`,
  `InternalAuditTest`, `CompetencyTrainingTest`, `RiskScoringTest` —
  18 new feature tests covering the happy paths and the
  segregation-of-duties / evidence / range-checking rules.
  Total suite is now **42 tests / 123 assertions**, all green.

### Notes
- All new clinical-style tables carry `created_by` / `updated_by` /
  `deleted_by` audit columns and use `SoftDeletes` via the
  `HasAuditColumns` + `IsLoggable` traits introduced in Phase 2 —
  every state change in the new modules ends up in `activity_logs`.
- This PR is **backend-first**: no Blade views or admin controllers
  for the new modules yet. The UI work lives in Phase 4 alongside
  the planned split of `DocumentController` so the new admin pages
  land on top of the post-split service layer rather than the
  current 1.5k-LOC God controller.

### Added — Phase 2 (Audit-ability foundation)
- **Blameable columns on every clinical table.** New migration
  `2026_05_14_040001_add_audit_columns_to_clinical_tables.php` adds
  `created_by`, `updated_by`, `deleted_by`, and `deleted_at` (soft-delete)
  to 23 clinical tables — `customers`, `documents`, `document_details`,
  `bios`, `bio_details`, `pbios`, `pbio_details`, `rxes`, `rx_details`,
  `hospital_treatments`, `medical_certificates`, `operative_protocols`,
  `schedules`, `events`, `orders`, etc. Required by ISO 9001:2015 §7.5.3
  ("control of documented information") and ISO 15189:2022 §8.4 ("control
  of records").
- **`App\Concerns\HasAuditColumns` trait.** Automatically stamps the
  `created_by`/`updated_by`/`deleted_by` columns from `Auth::user()` via
  the new `AuditableObserver`. Applied to all clinical models.
- **`SoftDeletes` on clinical models.** Patient/clinical records are no
  longer hard-deleted; instead `deleted_at` and `deleted_by` capture who
  withdrew the row and when, and rows are recoverable via `restore()`.
- **Append-only `activity_logs` table + `App\Models\ActivityLog`.** Stores
  every create/update/delete/restore on a loggable model with: causer
  user, IP address, user-agent, full field-level before/after JSON diff,
  and optional reason. Field-level redaction of passwords / tokens /
  secrets is performed centrally in `App\Services\ActivityLogService`.
- **`App\Concerns\IsLoggable` trait + `LoggableObserver`.** Wires any
  model into the audit log with one line.
- **Medical Record Number (MRN).** New `customers.mrn` column
  (`VARCHAR(32) UNIQUE`), populated automatically on create by
  `App\Services\MrnGenerator` in the deterministic
  `LAB-YYYY-NNNNNN` format. Race-safe via `SELECT ... FOR UPDATE` on
  MySQL/Postgres. Required by ISO 15189:2022 §7.2.2 (unique identification
  of every patient/specimen).
- **Reference ranges + critical-value flagging.** New
  `reference_ranges` table (per analyte × sex × age band, with normal
  and critical thresholds + unit) and `App\Services\ReferenceRangeLookup`
  which picks the most-specific applicable range and classifies a numeric
  value as `critical_low` / `low` / `normal` / `high` / `critical_high`.
  Required by ISO 15189:2022 §7.3.7.2 (biological reference intervals).
  `ReferenceRangeSeeder` ships a starter CBC / metabolic-panel pack.
- **Immutable result-release workflow on `bio_details`.** New columns
  `result_status` (enum: `draft` → `submitted_for_review` → `reviewed`
  → `released` → `amended`), `result_flag`, `submitted_by/_at`,
  `reviewed_by/_at`, `released_by/_at`, `amended_by/_at`,
  `amendment_reason`, and `amends_id` (FK back to `bio_details` for
  amendment chains). State transitions are owned by
  `App\Services\ResultReleaseService`, which enforces:
  - Forward-only progression — no rollback once released.
  - Segregation of duties — submitter ≠ reviewer ≠ releaser
    (ISO 15189:2022 §7.3.7.4).
  - Amendments require a non-empty reason and create a new appended
    row rather than mutating the released row.
  - Every transition writes an `activity_logs` row.
- **`App\Http\Controllers\Admin\ResultReleaseController`** with four
  POST endpoints under `/admin/results/{biodetail}/{submit|review|release|amend}`,
  each rate-limited via the `throttle:admin` limiter and each requiring
  the user's password as an electronic signature (21 CFR Part 11 /
  ISO 15189:2022 §7.3.7.4).
- **Tests.** `tests/Feature/AuditTrailTest`, `MrnGeneratorTest`,
  `ReferenceRangeLookupTest`, `ResultReleaseWorkflowTest` — 15 new
  feature tests covering the happy paths, segregation-of-duties
  rejection, amendment chain creation, MRN uniqueness/sequencing,
  reference-range specificity ordering, and soft-delete/restore.

### Changed — Phase 2
- `database/factories/UserFactory.php` now populates the legacy
  `username` and `phone_no` columns so `User::factory()->create()`
  works against the existing schema (used by all Phase 2 feature tests).

## Phase 1b (Security wrap-up: 2FA, password history, CI gates)

### Added
- **Two-factor authentication (TOTP, RFC 6238).** New `App\Services\TwoFactorService`
  generates 16-character base32 secrets via `pragmarx/google2fa-laravel`, renders
  QR codes via `bacon/bacon-qr-code`, and issues / verifies 8 single-use bcrypt-
  hashed recovery codes per user. New `users.two_factor_secret` (encrypted),
  `users.two_factor_recovery_codes` (`encrypted:array`), and
  `users.two_factor_confirmed_at` columns on `users`.
- **2FA enrolment & challenge flow.** `Auth\TwoFactorController` exposes
  `GET /two-factor/setup` (QR + recovery codes), `POST /two-factor/confirm`
  (6-digit verification), `GET /two-factor/challenge` and
  `POST /two-factor/verify` (login-time gate accepting either the TOTP or a
  recovery code), and `POST /two-factor/disable` (password-confirmation).
- **`EnsureTwoFactorVerified` middleware.** Applied to the entire
  `routes/admin.php` group — once a user has 2FA enabled, they must complete
  the challenge for every session before reaching any admin route.
- **Password-history prevention.** New `password_histories` table records
  bcrypt hashes (no plaintext) of the last *N* passwords per user, configured
  via `config/security.php` → `password_history.length` (default 5). The new
  `App\Rules\PreventPasswordReuse` validation rule blocks reuse and is wired
  into `UpdateUserRequest` and the password-reset flow.
  `App\Services\PasswordHistoryService` is invoked from `UserController` and
  `Auth\ResetPasswordController` to record new passwords and prune older
  entries.
- **`config/security.php`** — central feature flags for the 2FA and
  password-history features.
- **Tests.** New `tests/Feature/SecurityHeadersTest`,
  `tests/Feature/RateLimiterRegistrationTest`,
  `tests/Feature/ExampleTest` (root-redirect + login-renders smoke tests),
  and `tests/Unit/TwoFactorServiceTest` covering secret generation,
  verification, and recovery-code generation.
- **`pint.json`** — Laravel preset, excludes vendor/views/lang/seeders.

### Changed — Phase 1b
- **`bootstrap/app.php`** — moved the four named rate limiters
  (`login`, `public`, `admin`, `api`) from `RouteServiceProvider` into the
  `withRouting(then:)` closure so they are registered before any request
  middleware runs (previously the `login` limiter was *not* defined at
  request time in Laravel 12's bootstrap order, causing
  `Rate limiter [login] is not defined`).
- **`.github/workflows/ci.yml`** — un-gated the `pint` and `phpunit` jobs.
  The PHPUnit job now uses in-memory SQLite (see `phpunit.xml`) instead of
  spinning up a MySQL service; runs all tests on every push / PR.

### Fixed — Phase 1b
- **Critical: `SecurityHeaders` middleware was not applying any headers.**
  The Phase 1 guard `method_exists($response, 'headers')` always returned
  `false` because `headers` is a **property**, not a method, on Symfony's
  `Response`. Fixed by switching to `property_exists()`. As of this PR all
  responses correctly receive `X-Frame-Options`, `X-Content-Type-Options`,
  `Referrer-Policy`, `Permissions-Policy`, `Cross-Origin-Opener-Policy`, and
  `Content-Security-Policy`.

### Security
- Closes audit findings **M-1** (2FA), **M-2** (password history), and
  silently re-asserts **H-3** (security headers — see "Fixed" above) from
  [`docs/audit-report.md`](docs/audit-report.md).
- Aligns the codebase with **ISO 27001:2022 A.5.17** (authentication
  information), **NIST SP 800-63B §5.1.4** (Multi-Factor Authenticators),
  and **NIST SP 800-63B §5.1.1.2** (memorised secret reuse).

### Added — Phase 1 (Security baseline)
- `App\Http\Middleware\SecurityHeaders` — applies CSP, HSTS, X-Frame-Options,
  X-Content-Type-Options, Referrer-Policy, Permissions-Policy, and
  Cross-Origin-Opener-Policy to every response. CSP is intentionally loose
  to preserve existing jQuery/Bootstrap/inline-script behaviour; it will be
  tightened in Phase 4.
- `App\Http\Middleware\ForceHttpsInProduction` — 301-redirects plain HTTP
  to HTTPS in any non-`local`/`testing` environment.
- Named rate limiters in `App\Providers\RouteServiceProvider`:
  `login` (5/min per email+IP, 20/min per IP), `public` (120/min per IP),
  `admin` (300/min per user, 600/min per IP), and a per-user `api` limiter.
- FormRequest classes under `App\Http\Requests\Admin\` for User and Customer
  store/update flows, with strong password rules (NIST SP 800-63B: min 12,
  mixed case, digits, symbols) and image-upload constraints
  (`mimes:jpg,jpeg,png,webp`, `max:2048`).
- File-upload hardening in `UserController` and `CustomerController`: UUID
  filenames (no user influence over path or extension), server-side
  MIME-sniffed extension via `UploadedFile::extension()`, and explicit
  directory creation with safe permissions.

### Changed — Phase 1
- `App\Http\Middleware\AuthGates` — refactored to cache the
  Role → Permission map for 24 hours (`Cache::remember`) instead of
  rebuilding it from the DB on every request. Cache key:
  `auth_gates.permission_role_map`.
- `App\Models\Role` and `App\Models\Permission` — `booted()` hooks now
  invalidate the AuthGates cache on `saved` / `deleted` / `restored` so
  freshly granted or revoked permissions take effect on the next request.
- `routes/web.php` — wrapped `Auth::routes()` in the `throttle:login` group
  and the public AJAX endpoints (districts/communes/villages/locale/calendar)
  in the `throttle:public` group. Removed the bare `LIKE` query on the
  legacy `/get-countries` autocomplete (now uses a whitelisted column).
- `routes/admin.php` — added the `throttle:admin` middleware to the
  authenticated admin route group.
- `App\Http\Controllers\Admin\UserController` and
  `App\Http\Controllers\Admin\CustomerController` — replaced ad-hoc
  `Validator::make()` blocks with rules sourced from FormRequest classes,
  added explicit Gate checks per CRUD verb, and tightened the dual-purpose
  `store` action so update payloads no longer silently overwrite fields
  with `null`.

### Fixed — Phase 1
- XSS risk in `resources/views/vendor/translation/notifications.blade.php`
  where `Session::get('error')` was emitted via `{!! !!}` — now escaped.

### Security
- These changes address audit findings **H-3** (security headers), **H-4**
  (HTTPS enforcement), **H-5** (rate limiting), **H-6** (FormRequest
  validation), **H-7** (AuthGates N+1), and parts of **H-10** (`{!! !!}`
  outputs) from [`docs/audit-report.md`](docs/audit-report.md).

### Known issues / deferred
- Two-factor authentication is intentionally deferred to **Phase 1b** —
  it requires `pragmarx/google2fa-laravel` and a new `users` column, both
  of which are blocked on resolving the `composer.json` ↔ `composer.lock`
  drift first.
- Password history (preventing reuse of the last N passwords) is also
  Phase 1b — it requires a new migration.

### Added — Phase 0 (Emergency hygiene)
- Comprehensive `.gitignore` covering Laravel, Node, IDE, OS, and coverage files.
- `.gitattributes` to normalise line endings (LF) and mark archive-ignored files.
- Bilingual (English + Khmer) project `README.md` describing scope, install,
  ISO roadmap, and project structure.
- `LICENSE` (MIT) at repository root.
- `CONTRIBUTING.md` with branching model, Conventional Commits, ISO 9001
  change-control language, and Pull Request checklist.
- `SECURITY.md` with vulnerability-disclosure policy and post-leak APP_KEY
  rotation runbook.
- `.github/PULL_REQUEST_TEMPLATE.md` enforcing the ISO §8.5.6 PR description
  format.
- `.github/ISSUE_TEMPLATE/` with bug-report, feature-request, and
  ISO-non-conformance templates.
- `.github/CODEOWNERS` to define default reviewers.
- `.github/workflows/ci.yml` GitHub Actions pipeline running
  `composer validate`, PHPUnit, and a placeholder Pint check.
- `docs/audit-report.md` — full repository audit and phased improvement plan.
- `CHANGELOG.md` (this file).

### Changed
- `.env.example` documented with inline comments and safer defaults
  (`APP_DEBUG=false`, no real DB name).

### Removed (untracked, not yet purged from history)
- `.env` — was committed with a real `APP_KEY` and must be rotated.
- `node_modules/` (~51 MB, ~6000 files).
- `vendor/` (~72 MB, ~5000 files).
- `public/uploads/` (real customer/patient images, product photos).
- `storage/logs/*.log`.
- `CTempcomposer_output.txt` (build artefact accidentally committed from a
  Windows machine).

### Security
- ⚠️ The repository's first public commit (`3f0b20e`) included a real
  `APP_KEY` and credentials in `.env`. Operators **must** rotate these keys
  and consider purging the file from git history. See
  [`SECURITY.md`](SECURITY.md#what-to-do-if-app_key-was-leaked).

### Known issues
- `composer.json` declares `laravel/framework: ^12.0` but `composer.lock` is
  from a Laravel-10 install. Resolving this drift is tracked separately —
  see [`CONTRIBUTING.md`](CONTRIBUTING.md#composer-version-drift).

---

<!--
Future entries should be added above this line under [Unreleased],
then moved to a versioned section on release.

## [0.1.0] - YYYY-MM-DD
-->
