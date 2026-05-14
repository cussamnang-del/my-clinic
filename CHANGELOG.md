# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

This changelog also serves as evidence of *control of documented information*
required by ISO 9001:2015 §7.5.

---

## [Unreleased]

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
