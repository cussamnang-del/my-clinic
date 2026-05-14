# my-clinic — Clinic / Laboratory Management System

> A Laravel-based clinic & laboratory management system being progressively
> hardened toward an **ISO 9001:2015 + ISO 15189:2022**-compliant Laboratory
> Information Management System (LIMS).
>
> ប្រព័ន្ធគ្រប់គ្រងគ្លីនិច និងមន្ទីរពិសោធន៍ ផ្អែកលើ Laravel
> ដែលកំពុងត្រូវបានកែលម្អជាជំហានៗ ឆ្ពោះទៅរក​បទដ្ឋាន **ISO 9001:2015 + ISO 15189:2022**។

> ⚠️ **Status — Pre-release / under hardening.**
> Not certified, not production-ready. See [`SECURITY.md`](SECURITY.md) and the
> [Audit Report](docs/audit-report.md) for the list of outstanding work.

---

## សេចក្ដីសង្ខេបជាខ្មែរ (Khmer Summary)

`my-clinic` គឺជា​ប្រព័ន្ធ​គ្រប់គ្រង​គ្លីនិច ​និង​មន្ទីរ​ពិសោធន៍ ​ដែល​សរសេរ​ឡើង​ដោយ​ប្រើ
Laravel ។ វា​មាន​មុខងារ​ដូចជា ៖

- **ការ​ចុះ​ឈ្មោះ​អ្នកជំងឺ** — Patient registration (with province/district/commune/village).
- **ឯកសារ​ពិនិត្យ​ (Document)** — Visit records, life-signs, doctor’s description.
- **ការ​ពិនិត្យ​ជីវរស (Bio / Bio Analyst)** — Laboratory test ordering & results.
- **វេជ្ជបញ្ជា (Rx) + Nurse Rx** — Prescriptions, nurse-administered orders.
- **មន្ទីពេទ្យ​ (Hospital admission)** — In-patient treatment plans & notes.
- **ការ​លក់​ផលិតផល​ (Order / Receipt)** — Product orders & receipts.
- **ការ​គ្រប់​គ្រង​បុគ្គលិក​ និង​សិទ្ធិ (RBAC)** — Users, roles, permissions.
- **កាលវិភាគ​ (Schedule)** — FullCalendar-based scheduling.
- **ពហុ​ភាសា (i18n)** — English + ខ្មែរ.

ការ​អភិវឌ្ឍ​បច្ចុប្បន្ន​ផ្ដោត​លើ​ ​ការ​ធ្វើ​ឲ្យ​ប្រព័ន្ធ​នេះ​ឆ្លើយ​តប​នឹង​ ​ស្ដង់ដារ​សុវត្ថិភាព ​និង
គុណភាព​អន្តរជាតិ ​សម្រាប់​ប្រព័ន្ធ​គ្រប់គ្រង​មន្ទីរ​ពិសោធន៍​វេជ្ជសាស្ត្រ ។

---

## Table of contents

- [Features](#features)
- [Tech stack](#tech-stack)
- [Requirements](#requirements)
- [Quick start](#quick-start)
- [Configuration](#configuration)
- [Running tests](#running-tests)
- [Code style & quality gates](#code-style--quality-gates)
- [Project structure](#project-structure)
- [ISO 9001 / ISO 15189 roadmap](#iso-9001--iso-15189-roadmap)
- [Security](#security)
- [Contributing](#contributing)
- [License](#license)

---

## Features

| Module | Status |
|---|---|
| Patient (Customer) registration | ✅ Implemented |
| Visit Documents | ✅ Implemented |
| Life signs / Vitals | ✅ Implemented |
| Laboratory tests (Bio / Bio Analyst) | ✅ Basic, ⚠️ no formal result-release workflow |
| Prescriptions (Rx) | ✅ Implemented |
| Hospital admission & treatment notes | ✅ Implemented |
| Product catalogue & orders | ✅ Implemented |
| Schedule / Calendar | ✅ Implemented |
| RBAC (Roles & Permissions) | ✅ Implemented |
| Multilingual (English + Khmer) | ✅ Implemented |
| **Audit trail (who/when/what changed)** | ❌ Planned — Phase 2 |
| **Document control / SOP versioning** | ❌ Planned — Phase 3 |
| **Equipment & Calibration records** | ❌ Planned — Phase 3 |
| **Reagent / Lot / Expiry tracking** | ❌ Planned — Phase 3 |
| **NCR / CAPA module** | ❌ Planned — Phase 3 |
| **Internal Audit & Management Review** | ❌ Planned — Phase 3 |
| **Critical-value alerts & reference ranges** | ❌ Planned — Phase 2 |
| **Electronic signature / Result release** | ❌ Planned — Phase 2 |

See the [Audit Report](docs/audit-report.md) for the full gap analysis.

---

## Tech stack

- **PHP** ^8.3
- **Laravel** — see [`composer.json`](composer.json) for the active major version
- **MySQL** 8.x (or MariaDB 10.6+)
- **Bootstrap 5** + jQuery
- **Vite** 6 for asset bundling
- **PHPUnit** 11 for tests
- **Laravel Sanctum** for token-based auth (`/api/user`)
- Helper packages: `staudenmeir/eloquent-has-many-deep`,
  `staudenmeir/belongs-to-through`, `orangehill/iseed`

> ⚠️ **Known mismatch.** `composer.json` currently declares
> `laravel/framework: ^12.0`, but `composer.lock` is locked to Laravel 10.
> See [`CONTRIBUTING.md`](CONTRIBUTING.md#composer-version-drift) for the plan
> to reconcile this — do **not** run `composer install` blindly until that is
> resolved.

---

## Requirements

- PHP **>= 8.3** with extensions: `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`,
  `intl`, `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `zip`, `gd`.
- Composer **>= 2.5**.
- Node **>= 18** + npm.
- MySQL **>= 8.0** (or MariaDB **>= 10.6**).
- A web server (Apache with `mod_rewrite`, or nginx + php-fpm), or Laravel
  Sail / Laravel Herd for local development.

---

## Quick start

```bash
# 1. Clone
git clone https://github.com/cussamnang-del/my-clinic.git
cd my-clinic

# 2. PHP dependencies
composer install

# 3. JS dependencies
npm install

# 4. Environment
cp .env.example .env
php artisan key:generate

# 5. Configure DB in .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD), then:
php artisan migrate --seed

# 6. Storage symlink for uploaded files
php artisan storage:link

# 7. Build front-end (development)
npm run dev
# or production
npm run build

# 8. Serve
php artisan serve
# open http://127.0.0.1:8000
```

After seeding, log in with the default super-admin user created by
`UserTableSeeder` (check the seeder for credentials — and **change them
immediately**).

---

## Configuration

All runtime configuration is via the `.env` file. A documented template lives
at [`.env.example`](.env.example).

Key variables:

| Variable | Purpose | Notes |
|---|---|---|
| `APP_NAME` | Display name | e.g. `"Clinic Management System"` |
| `APP_ENV` | Environment | `local` / `staging` / `production` |
| `APP_KEY` | Encryption key | **Must** be set via `php artisan key:generate` and rotated immediately if leaked |
| `APP_DEBUG` | Show debug pages | **Must** be `false` in production |
| `APP_URL` | Public URL | e.g. `https://clinic.example.org` |
| `APP_TIMEZONE` | Default timezone | `Asia/Phnom_Penh` for Cambodia, `UTC` otherwise |
| `DB_*` | Database | MySQL 8.x |
| `MAIL_*` | SMTP | Required for password reset, notifications |
| `SESSION_DRIVER` | Session storage | `file` (default) or `redis` in production |
| `QUEUE_CONNECTION` | Queue backend | `sync` (default) — switch to `redis` for production |

> ⚠️ **Never commit `.env`.** It is in [`.gitignore`](.gitignore). If a
> previous version was accidentally committed, see
> [`SECURITY.md`](SECURITY.md#what-to-do-if-app_key-was-leaked).

---

## Running tests

```bash
# Full test suite
php artisan test
# or
./vendor/bin/phpunit

# Single test
php artisan test --filter=ExampleTest
```

> The existing test suite currently contains only Laravel scaffolded examples.
> Test coverage is part of the [Operational excellence roadmap](docs/audit-report.md#phase-4--operational-excellence).

---

## Code style & quality gates

We follow **PSR-12** with Laravel-flavored Pint defaults.

```bash
# Format (run before committing)
./vendor/bin/pint

# Check (CI uses this — fails the build if files need formatting)
./vendor/bin/pint --test
```

Continuous Integration runs on every Pull Request via
[`.github/workflows/ci.yml`](.github/workflows/ci.yml). The pipeline runs:

1. `composer validate --strict`
2. `composer install`
3. `./vendor/bin/pint --test`
4. `php artisan test`

PRs are **not mergeable** unless CI is green.

---

## Project structure

```
app/
├─ Http/
│  ├─ Controllers/        # MVC controllers (Admin/* for back-office)
│  └─ Middleware/         # Auth gates, language switcher, etc.
├─ Models/                # Eloquent models
├─ Providers/             # Service providers
└─ Helpers/               # Custom helpers (autoloaded via composer.json)
config/                   # Laravel config files
database/
├─ migrations/            # Schema migrations
├─ seeders/               # Reference data + initial admin user
└─ factories/             # Model factories for tests
resources/
├─ views/                 # Blade templates
├─ js/, css/, sass/       # Vite-bundled front-end
└─ lang/                  # i18n (en, km)
routes/
├─ web.php                # Public web routes
├─ admin.php              # Back-office (auth-protected) routes
├─ api.php                # API (sanctum-protected)
└─ console.php            # Artisan commands
tests/                    # PHPUnit tests
docs/                     # Project documentation (audit report, ISO mapping, …)
```

---

## ISO 9001 / ISO 15189 roadmap

This project is being progressively hardened toward
**ISO 9001:2015** (Quality Management Systems) and
**ISO 15189:2022** (Medical laboratories — Requirements for quality and
competence). See the full [Audit Report](docs/audit-report.md) for the gap
analysis and the phased plan:

- **Phase 0 — Emergency hygiene** *(this PR)* — `.gitignore`, secrets,
  README/LICENSE/CONTRIBUTING/SECURITY, CI baseline.
- **Phase 1 — Security baseline** — FormRequest validation, file-upload
  hardening, rate-limiting, security headers, 2FA.
- **Phase 2 — Audit-ability foundation** — `created_by` / `updated_by` /
  `deleted_by` columns, activity log, soft-delete on clinical models,
  MRN generator, reference ranges, electronic-signature result release.
- **Phase 3 — ISO modules** — Document Control, Equipment & Calibration,
  Reagent Lots, NCR / CAPA, Internal Audit, Management Review, Training &
  Competency, Risk Register.
- **Phase 4 — Operational excellence** — split fat controllers, service
  layer, API resources, queues, observability, backups, ≥ 70% test coverage.
- **Phase 5 — Reporting & validation** — KPI dashboards (TAT, NCR closure),
  Levey-Jennings IQC, EQA / Proficiency-Testing import, patient portal,
  Computer-System Validation (IQ/OQ/PQ) package.

---

## Security

If you discover a security vulnerability, please follow the disclosure process
in [`SECURITY.md`](SECURITY.md). **Do not** open a public GitHub issue for
security problems.

---

## Contributing

Pull Requests are welcome. Please read [`CONTRIBUTING.md`](CONTRIBUTING.md)
first — it covers the branching model, ISO-style change control, commit
message format, and the local development setup.

---

## License

Released under the [MIT License](LICENSE).
