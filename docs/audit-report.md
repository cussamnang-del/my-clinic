# Audit Report — `cussamnang-del/my-clinic`
## Conversion to ISO 9001:2000-compliant Laboratory Management System (LIMS)

**Auditor:** Devin (acting as ISO 9001 / Web Development System auditor)
**Date:** 2026-05-14
**Repository:** https://github.com/cussamnang-del/my-clinic
**Commit audited:** `3f0b20e` (single commit "first commit")
**Stack detected:** Laravel 12 (composer.json) but `composer.lock` is locked to Laravel 10.17–10.24 → version drift. PHP ^8.3. MySQL. Bootstrap 5 + Vite. jQuery/Ajax-driven blade templates.

---

## សេចក្ដីសង្ខេបជាភាសាខ្មែរ (Executive Summary — Khmer)

ប្រព័ន្ធនេះ ​បច្ចុប្បន្ន​គឺជា **Clinic Management System** ដែលរួមមាន​មុខងារ ​ចុះឈ្មោះ​អ្នកជំងឺ, ​ការពិនិត្យជីវរស (Bio/BioDetail), ​វេជ្ជបញ្ជា (Rx), ​មន្ទីពេទ្យ (Hospital), ​ការគ្រប់គ្រងផលិតផល (Product/Order) ។ វាមាន **គ្រឹះ​មួយ​ចំនួន** ដែលប្រើបាន (RBAC, Eloquent models, multilingual EN/KM) ​ប៉ុន្ដែ​មាន​ចំណុចខ្វះខាត​យ៉ាង​ធ្ងន់ធ្ងរ​សម្រាប់ ISO 9001 LIMS ៖

🔴 **គ្រោះថ្នាក់សុវត្ថិភាព Critical (ត្រូវតែ​ដោះស្រាយ​ភ្លាមៗ)** ៖ `.env` (រួមទាំង​ `APP_KEY`) ត្រូវ​បាន​ commit ចូល git, គ្មាន `.gitignore`, `node_modules` (51 MB) និង `vendor` (72 MB) ត្រូវ​បាន​ commit (15,075 files), `APP_DEBUG=false` ​ល្អ​តែ​ APP_KEY ​បានលេចចេញ​ហើយ​ត្រូវ​ rotate ភ្លាមៗ ។

🟠 **គ្មាន​ Audit Trail** ៖ ISO 9001 ត្រូវ​ការ​កំណត់​ត្រា ​ថា​នរណា​ផ្លាស់ប្ដូរ​អ្វី ​ពេលណា ​ប៉ុន្ដែ​ project នេះមាន​តែ `created_at` / `updated_at` ​មិន​មាន `created_by` / `updated_by` / `deleted_by` ​ឬ ​ការ​ log change history ឡើយ ។

🟠 **គ្មាន​ Sample / Specimen Workflow ច្បាស់​លាស់** ៖ ការ​បញ្ជា​ test​ ទៅ​លទ្ធផល​ ​ការ​ review ​ការ​ approve ​មុន​បញ្ចេញ​លទ្ធផល មិន​ត្រូវ​បាន​ បំបែក​ ជា​ states ច្បាស់​លាស់​ទេ ។

🟠 **គ្មាន​ Document Control / Versioning** សម្រាប់ SOPs, Methods, Reference ranges ។

🟠 **គ្មាន​ Calibration / Equipment / Reagent Lot tracking** ។

🟠 **គ្មាន​ NCR/CAPA module** (Non-Conformance Reports, Corrective & Preventive Action) ​ដែល​ជា​សន្លឹក​បេះដូង​នៃ ISO 9001 Clause 8.3 + 8.5 ។

🟠 **គុណភាព​កូដ** ៖ `DocumentController.php` មាន​ 1,874 បន្ទាត់ (God class), `$guarded = []` ស្ទើរ​គ្រប់​ model, គ្មាន​ Request Validation classes, គ្មាន​ unit / feature tests, គ្មាន CI/CD ។

📌 **អនុសាសន៍ខ្ញុំ** ៖ ខ្ញុំ​នឹង​ស្នើ **5 Phases** ​នៃ​ ការ​កែ​លម្អ ​ដូច​ខាង​ក្រោម ហើយ​សុំ​លោក​អ្នក​សម្រេច​ថា ​ខ្ញុំ​ត្រូវ​ធ្វើ ​phase ណា​ខ្លះ​ក្នុង PR ​បន្ទាប់ ។

> ⚠️ **កំណត់​សម្គាល់​សំខាន់ ៖ ISO 9001:2000 ត្រូវ​បាន​ដក​ហូត​ហើយ** (superseded ដោយ ISO 9001:2008 បន្ទាប់​មក​ ISO 9001:2015) ​ហើយ​សម្រាប់​មន្ទីរ​ពិសោធន៍​វេជ្ជសាស្ត្រ ​ស្ដង់ដារ​ ​ជាក់លាក់​ ​គឺ **ISO 15189:2022** (Medical laboratories — Requirements for quality and competence) ។ របាយការណ៍​នេះ​ខ្ញុំ​ប្រើ ​គោលការណ៍ ISO 9001 (ដែល​ប្រើ​បានរឺ​ ISO 9001:2015) រួម​ផ្សំ​នឹង​ ​មាត្រា​ ​ដែល​មាន​លក្ខណៈ​ LIMS ​ពី ISO 15189 ។ ប្រសិន​បើ​ លោក​អ្នក​ត្រូវ​ការ​ ​ISO 9001:2000 ច្បាស់ៗ (1994 → 2000 cancelled in 2009) សូម​ប្រាប់ខ្ញុំ ។

---

## 1. Tech-stack Inventory

| Layer | Detected | Notes / Risk |
|---|---|---|
| Framework | Laravel ^12.0 (composer.json) | `composer.lock` is locked to ≥10.17 <10.25 → **version mismatch**; running `composer install` will fail or downgrade |
| Language | PHP ^8.3 | OK |
| DB | MySQL (DB_CONNECTION=mysql) | OK; uses migrations |
| Auth | Laravel built-in + Sanctum + laravel/ui scaffolding | No 2FA, no password expiry, no account lockout |
| Frontend | Bootstrap 5, jQuery, Vite, Sass | Heavy reliance on inline jQuery+blade |
| i18n | EN + KM (lang/) + session locale switch | OK |
| Helper libs | `staudenmeir/eloquent-has-many-deep`, `belongs-to-through`, `orangehill/iseed`, `barryvdh/laravel-debugbar` (in `require-dev`) | OK |
| Test framework | PHPUnit 11 | Only Laravel example tests; **0 real tests** |
| Lint / Format | `.styleci.yml` (StyleCI service, now legacy) | No Pint, no PHPStan, no Psalm, no Larastan |
| CI/CD | **None** | `.travis.yml` shield in README is dead; no `.github/workflows` |
| Dependency manager files committed | `vendor/` (72 MB, ~9k files), `node_modules/` (51 MB) | **Critical** — must be in `.gitignore` |

---

## 2. CRITICAL Findings (must fix before any production use)

### C-1 Committed secrets in `.env` (CRITICAL)
The actual production-style `.env` file is in git history:
- `APP_KEY=base64:4wDAUiNKp8j9aO5ypw0C/36a0XGnqdvUSXv7InHsHwI=` is now public.
- All Laravel encryption (session cookies, signed URLs, encrypted DB columns) is broken.
- **Action:** add `.env` to `.gitignore`, run `git filter-repo` to purge it, rotate `APP_KEY` (and re-encrypt any data), rotate all DB/SMTP/Pusher credentials.

### C-2 No `.gitignore` file
- Repo size is bloated (~85 MB clone, 16,340 objects).
- `vendor/`, `node_modules/`, `storage/logs/*`, `.env`, `*.swp`, `.idea/`, `.vscode/`, `public/uploads/` are all tracked.
- **Action:** add Laravel-standard `.gitignore`, `git rm -r --cached` the tracked dirs, commit.

### C-3 Single "first commit" history
- No CONTRIBUTING.md, no PR template, no branch protection, no semantic commits.
- ISO 9001 Clause 7.5 (Operation control of documented information) requires traceable history of changes.
- **Action:** start using feature branches + PRs; enable required reviews on `main`.

### C-4 `composer.lock` ≠ `composer.json` (Laravel 10 vs 12)
- Running `composer install` will likely fail or pull divergent versions.
- **Action:** decide on one Laravel major version (12 is current LTS), run `composer update`, commit a fresh lock-file.

### C-5 Default Laravel `README.md`
- No description of what the system does, how to install, how to run tests, ISO scope, supported lab tests, user roles, etc.
- **Action:** replace with project README documenting LIMS scope, setup, ISO context.

---

## 3. HIGH Findings (security / data integrity)

### H-1 No audit trail (ISO 9001 §4.2.4 + §8.2.2)
Models use only `created_at` / `updated_at`. There is no:
- `created_by`, `updated_by`, `deleted_by` columns on any table.
- Activity log of *before* / *after* values for changes to clinical data.
- Append-only audit table.

For a LIMS, every change to a patient result, dose, sample status, or report must be traceable to a named user with timestamp and (ideally) reason.

**Action:** install `spatie/laravel-activitylog`, add `created_by` / `updated_by` to all clinical tables via a `BlameableObserver`, log every relevant change to `activity_log`.

### H-2 Mass-assignment is wide-open
Most models declare `protected $guarded = [];` (i.e. *all* attributes are mass-assignable). Combined with `Model::updateOrCreate($request->all())` patterns in many controllers, this allows attackers to overwrite columns like `status`, `user_id`, `created_at`, `register_by`, etc.

**Action:** replace with explicit `$fillable = [...]` per model, OR keep `$guarded` but never pass `$request->all()` — use FormRequest::validated() instead.

### H-3 No FormRequest validation classes
All validation is inline `Validator::make($request->all(), [...])` inside fat controllers. This:
- Bypasses Laravel's authorization layer (`authorize()`).
- Makes validation rules un-reusable and un-testable.
- Often forgets fields (e.g. `CustomerController::store` does **not** validate `province_id`, `phone_no`, `photo` file type/size, but trusts them).

**Action:** create `app/Http/Requests/StoreCustomerRequest.php`, `UpdateCustomerRequest.php`, etc.; centralise rules.

### H-4 File upload security
- `$image->getClientOriginalExtension()` is trusted (client-supplied) — caller can upload `.php` renamed to `.jpg`.
- No MIME validation, no size cap, no virus scan, no random filename via `Str::uuid()` + `store()`.
- Files are written to `public_path('uploads/...')` (publicly servable, indexable).

**Action:** use `$request->file('photo')->store('customers', 'public')` + `mimes:jpg,png,webp|max:2048` validation; never trust the extension.

### H-5 No rate limiting on auth & search endpoints
- `routes/web.php` `/get-countries` does a `LIKE` DB query unauthenticated and with no throttle → trivial DoS.
- Login does not use `throttle:5,1` middleware (only Laravel default).
- Password reset is not throttled in this project.

**Action:** add `->middleware('throttle:60,1')` on public endpoints; tighten login throttle.

### H-6 No HTTPS enforcement / security headers
- `AppServiceProvider` doesn't call `URL::forceScheme('https')`.
- No CSP, no HSTS, no X-Frame-Options/Permissions-Policy middleware.
- `.htaccess` is Apache-only — no nginx or container deployment guidance.

**Action:** add `\App\Http\Middleware\SecurityHeaders` setting CSP/HSTS/etc, force HTTPS in production.

### H-7 `AuthGates` middleware is inefficient and runs on every request
It queries `Role::with('permissions')->get()` and re-defines every Gate on **every HTTP request** (incl. static assets if hit by a route). This:
- Blows up DB load.
- Cannot be cached.

**Action:** move gate registration into `AuthServiceProvider::boot()` with a cache (`Cache::rememberForever('permissions', ...)`), invalidate on role/permission save.

### H-8 Soft-delete is inconsistent
Only `User` model has `SoftDeletes`. Customers, Documents, Bios, Rx, Orders, etc. are hard-deleted. ISO 9001 §4.2.4 requires records to be **legible, readily identifiable and retrievable** for a **defined retention period** — hard deletes violate this.

**Action:** add `SoftDeletes` + `deleted_by` to every clinical model; never destructively delete patient data.

### H-9 No HTTPS / TLS for DB or external integrations
- `DB_HOST=localhost` is fine, but no `MYSQL_ATTR_SSL_CA` in `config/database.php` for cloud DB.
- No queue worker config (uses `sync`), no Redis/Pusher SSL.

### H-10 Blade `{!! ... !!}` raw output in 9+ templates
Some are safe (JSON encode) but several render user-controlled or DB-derived names without escaping (`lifesign->name`, `coldesr`, `error` from session). Risk of stored XSS.

**Action:** audit each `{!! !!}` site; replace with `{{ }}` (auto-escaped) unless intentional HTML, in which case sanitise with `Purifier`.

---

## 4. MEDIUM Findings (architecture / maintainability)

### M-1 `DocumentController` is 1,874 lines (God class)
It handles: documents, bios, p-bios, doctor descriptions, Rx, Rx nurse, hospital admission, hospital treatment, hospital notes, document life vitals, orders, injections, receipts, treatment filters, product search, customer creation. This violates SRP and makes reasoning, testing, and reviewing impossible.

**Action:** split into 10+ controllers (`BioController`, `RxController`, `HospitalController`, `OrderController`, `LifeSignController` — most names exist but logic lives in DocumentController). Extract a Service layer (`BioService`, `RxService`).

### M-2 Routes pass model IDs via query strings & non-RESTful verbs
- `/admin/documents/storeBio` (POST), `/admin/documents/getBio` (GET), `/admin/documents/deletePBio` (POST) — should be `POST /admin/bios`, `GET /admin/bios/{id}`, `DELETE /admin/bios/{id}`.
- Route names like `documents.bio.receipt` work but are confusing.

**Action:** introduce `Route::resource('bios', BioController::class)` style; use API resources.

### M-3 No Service / Repository layer
Eloquent calls are inline in controllers. Hard to swap, test, mock.

### M-4 No Eloquent API Resources / DTOs
Controllers return raw models as JSON, exposing internal column names and any added relationships.

### M-5 No queue jobs / background processing
Email and notifications use `QUEUE_CONNECTION=sync`. PDFs are likely generated in-request (search: `pdfPreview`).

### M-6 No structured logging / observability
`LOG_CHANNEL=stack`, `LOG_LEVEL=debug`. No request_id correlation, no metrics endpoint, no error tracking (Sentry/Bugsnag), no audit log channel.

### M-7 N+1 queries everywhere
e.g. `Document::hospital(0)->latest()->get()` then template iterates `$row->customer->name`, `$row->lifesign->name`, etc. without eager-loading.

**Action:** add `->with(['customer','user','lifesign','district', ...])` and `Model::preventLazyLoading()` in non-prod.

### M-8 Untyped methods, no PHPDoc on most controllers
- Most controller methods have no return type, no parameter type beyond `Request`.
- Will not pass `phpstan level 5+`.

### M-9 Migrations carry permission inserts mixed with schema
Several `*_create_*_table.php` migrations also `DB::table('permissions')->insert($permissions);` — coupling schema & data, making rollback unsafe.

**Action:** move permission seed to dedicated seeders.

### M-10 No tests, no test DB config
- `phpunit.xml` has SQLite in-memory commented out.
- Only 2 example tests.
- No factories beyond 4.

ISO 9001 §7.3 (Design and Development) requires verification & validation — testing is the implementation of that clause.

### M-11 No CI: no lint, no test, no security scan
No GitHub Actions / GitLab CI.

### M-12 i18n: only views are translated, validation messages partial
`lang/` has KM directory, but several admin views still hard-code English strings (`<th>Customer Name</th>` etc.).

### M-13 Time-zone / Date handling
`.env` `APP_TIMEZONE=UTC` but customer-facing UI is in Cambodia (Asia/Phnom_Penh). Mixed `date('Y-m-d')` + `Carbon`. Lab specimen times should be ISO-8601 with timezone — currently stored as naive `dateTime`.

### M-14 Hard-coded admin role
`User::getIsAdminAttribute` checks `$this->roles()->where('id', 1)`. Magic number 1.

### M-15 `Customer::create` doesn't generate `customer_code` (set to `null`)
For a lab, every patient must have a unique, human-readable Patient/MRN code — required for traceability per ISO 15189 §5.4.5.

### M-16 Inconsistent indentation
Mix of 2-space and 4-space across files. No `.editorconfig` enforcement of Pint.

### M-17 `composer.json` includes `barryvdh/laravel-debugbar` only in dev — good, but no check that it isn't enabled in production.

---

## 5. LOW Findings (polish)

- `CTempcomposer_output.txt` (9KB) — junk file committed.
- `webpack.mix.js` present alongside `vite.config.js` — pick one (Vite).
- Many `// TODO`-style comments and commented-out code blocks (e.g. `routes/web.php`).
- `routes/web.php`: `/auto`, `/get-countries`, `/full-calendar` look like dev leftovers exposed unauthenticated.
- `Route::resource(...)` calls do `->except('create', 'update')` everywhere — inconsistent; if you're rolling your own AJAX edit, do it once and document.
- No OpenAPI/Swagger doc for the (currently 1-route) API.
- No `LICENSE` file at repo root (composer.json says MIT, but no actual LICENSE).

---

## 6. ISO 9001 / ISO 15189 LIMS Compliance Gap-Analysis

> Mapping the missing capabilities to the clauses of ISO 9001:2015 (effectively the successor of 9001:2000) and the LIMS-specific ISO 15189:2022 (medical labs).

| Clause | Requirement | Status | Gap |
|---|---|---|---|
| ISO 9001 §4.4 — QMS process approach | Documented processes for each lab activity | ❌ | No process diagrams, no SOP repository module |
| §5 — Leadership & policy | Quality policy, objectives, management review records | ❌ | No `policies`, `management_reviews` tables |
| §6 — Planning, risk-based thinking | Risk register | ❌ | Not present |
| §7.1.3 — Infrastructure | Equipment inventory & calibration | ❌ | No `equipment`, `calibrations` tables |
| §7.1.5 — Monitoring & measuring resources | Calibration certificates, traceability to national standards | ❌ | Missing |
| §7.2 — Competence | Training records, competency assessments | ❌ | No `trainings`, `competencies`, `user_certifications` |
| §7.5 — Documented information / Document control | Version, approval, distribution, obsolete-copy control of SOPs | ❌ | No SOP/document control module (there's a `Document` model, but that's a *patient* file, not an SOP) |
| §8.3 — Control of NC outputs | NCR — Non-Conformance Reports | ❌ | Missing |
| §8.5.6 — Control of changes | Change-control log | ❌ | Missing |
| §8.7 — Control of nonconforming outputs | Action on rejected sample / failed QC | ❌ | Missing |
| §9.1 — Monitoring & evaluation | KPIs, dashboards, turnaround time | ⚠️ | Calendar exists; no TAT, QC stats, control charts |
| §9.2 — Internal audit | Internal audit module | ❌ | Missing |
| §9.3 — Management review | Management review module | ❌ | Missing |
| §10.2 — CAPA | Corrective & Preventive Action | ❌ | Missing |
| **ISO 15189 §5.4** — Pre-examination | Sample reception, accession, rejection criteria | ⚠️ | Customer + Bio exist; no specimen status workflow (Received / Accepted / Rejected / Reason) |
| §5.5 — Examination processes | Method validation, IQC, EQA (PT) | ❌ | No QC samples, no Levey-Jennings, no PT records |
| §5.6 — Quality assurance | Verification of examination procedures | ❌ | Missing |
| §5.7 — Post-examination | Result review, authorization, release, amendment | ⚠️ | Bio has results but no workflow `pending → reviewed → released → amended`, no electronic signature |
| §5.8 — Reporting of results | Reference ranges, units, flags, critical-value alerts | ⚠️ | BioDetail has values; no reference range bands, no critical-value flag, no clinician acknowledgement |
| §5.9 — Release of results | Authorized signatory, lock after release | ❌ | Records remain editable forever |
| §5.10 — Laboratory information management | Audit trail, downtime procedures, backup | ❌ | No audit trail (see H-1), no documented backup |
| 21 CFR Part 11 (FDA, electronic records) | Electronic signatures, audit trail, validation | ❌ | Important if exporting to US — fully missing |

---

## 7. Proposed Phased Improvement Plan

### **Phase 0 — Emergency hygiene (1 small PR, can ship today)**
The minimum to make the repo professional. **I recommend approving Phase 0 immediately.**

1. Add `.gitignore` (Laravel + Node + IDE).
2. Remove `node_modules/`, `vendor/`, `storage/logs/*.log`, `.env`, `CTempcomposer_output.txt` from tracked files.
3. Replace `.env` with documented `.env.example`; force `APP_KEY` rotation.
4. Replace default Laravel `README.md` with project README (English + Khmer): purpose, ISO scope, install, run, test, deploy.
5. Add `LICENSE` (MIT, matching composer.json).
6. Reconcile `composer.json` ↔ `composer.lock` — pick Laravel 12 (since composer.json declares it) and regenerate `composer.lock`.
7. Add `.editorconfig` enforcement + `laravel/pint` dev dep, with a `composer lint` script.
8. Add a minimal GitHub Actions CI workflow that runs Pint + PHPUnit on PRs.
9. Add `.github/PULL_REQUEST_TEMPLATE.md` and `CONTRIBUTING.md` aligning with ISO change-control wording.

### **Phase 1 — Security baseline**
1. Replace `$guarded = []` with explicit `$fillable` on every model.
2. Move every inline `Validator::make()` to `app/Http/Requests/*Request.php` FormRequests.
3. File-upload hardening: `mimes`, `max`, UUID filenames, `storage/app/public` symlink, image MIME sniff.
4. Rate-limit auth routes & search endpoints.
5. Add `SecurityHeaders` middleware (CSP, HSTS, X-Frame-Options, Referrer-Policy, Permissions-Policy).
6. Force HTTPS in production.
7. Move `AuthGates` permission registration to `AuthServiceProvider::boot()` with cache invalidation on Role/Permission save.
8. Audit & fix every `{!! !!}` in blade views.
9. Add account-lockout (`Illuminate\\Auth\\Events\\Lockout` + custom backoff) and password policy (min 12, complexity, history, expiry).
10. Add 2FA (e.g. `pragmarx/google2fa-laravel`) — recommended for ISO 27001 alignment.

### **Phase 2 — ISO 9001 audit-ability foundation**
1. Add `created_by` / `updated_by` / `deleted_by` columns to **all** clinical tables via a Blameable trait.
2. Install `spatie/laravel-activitylog`, configure to log every clinical model change with before/after diff and reason.
3. Add `SoftDeletes` to all clinical models.
4. Add `customer_code` (MRN) generator: `LAB-YYYY-NNNNNN`, unique, indexed.
5. Introduce immutable result-release workflow with electronic signature:
   - States: `draft → submitted_for_review → reviewed → released → amended`.
   - Once `released`, edits create an `amendment` (append-only).
6. Add Reference Ranges table (per test × sex × age band × unit), with critical-value thresholds and auto-flagging.

### **Phase 3 — ISO 9001 quality-management modules**
1. **Document Control module** — versioned SOPs/Methods, approval workflow, training acknowledgements.
2. **Equipment & Calibration** — equipment inventory, calibration schedule, certificates, due-date alerts.
3. **Reagents & Lots** — lot numbers, expiry, on-hand qty, link to test results.
4. **NCR / CAPA** — non-conformance reporting, root-cause analysis, corrective & preventive action with effectiveness review.
5. **Internal Audits** — audit plan, findings, follow-up.
6. **Management Review** — agenda, inputs, outputs, action items.
7. **Training & Competency** — per-user record, expiry, re-assessment dates.
8. **Risk Register** — risks, likelihood × severity, mitigation.

### **Phase 4 — Operational excellence**
1. Split `DocumentController` into bounded contexts.
2. Service layer + Repository pattern for clinical entities.
3. Eloquent API Resources + OpenAPI doc.
4. Eager-loading + `preventLazyLoading()`; pagination on all index lists.
5. Queue-based PDF generation + emailing; `QUEUE_CONNECTION=redis` in prod.
6. Sentry / Bugsnag integration.
7. Backup module (`spatie/laravel-backup`) — daily DB + uploads to encrypted S3.
8. PHPStan / Larastan level 6 + full Pint enforcement; pre-commit hook.
9. Pest or PHPUnit Feature tests for every controller (≥ 70% coverage gate).
10. Browser tests (Dusk) for the result-release & specimen workflow.

### **Phase 5 — Reporting, dashboards & validation**
1. KPI dashboard — Turn-Around Time per test, % critical-value alerts acknowledged in ≤ time, rejection rate, NCR closure rate.
2. Levey-Jennings control charts for IQC; Westgard rules.
3. External QA / Proficiency-Testing imports.
4. PDF result sheets with signed-off authorisation block.
5. Customer (patient) portal for result retrieval with 2FA.
6. Computer-System Validation (CSV) package: IQ/OQ/PQ scripts.

---

## 8. Recommendation to user

I recommend we start with **Phase 0 (Emergency hygiene)** as a single PR today — it is small, safe, brings the repo up to industry baseline, and unblocks every subsequent phase. After you approve and we merge Phase 0, we tackle Phase 1 (Security baseline) next, and so on.

Please confirm which phase(s) you would like me to implement in the **next PR**:

- [ ] **Phase 0 only** (recommended starting point — small, safe, ~1 PR)
- [ ] **Phase 0 + Phase 1** (hygiene + security — larger PR, ~2–3 days of work)
- [ ] **Phase 0 → Phase 2** (hygiene + security + audit-trail foundation — substantial, ~1 week)
- [ ] **Phase 0 → Phase 5 (full transformation)** (very large, multiple PRs over weeks; we will split into many PRs)
- [ ] Other / custom scope (please tell me)

I will wait for your approval before writing any code changes.
