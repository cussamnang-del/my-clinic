# Contributing to `my-clinic`

Thank you for your interest in contributing! This project is being hardened
toward **ISO 9001:2015** (Quality Management Systems) and **ISO 15189:2022**
(Medical laboratories), and we apply the same rigour to its development
process. Please read this guide before opening a Pull Request.

## Table of contents

- [Code of conduct](#code-of-conduct)
- [Branching model](#branching-model)
- [Change control (ISO 9001 §8.5.6)](#change-control-iso-9001-856)
- [Commit messages](#commit-messages)
- [Local development setup](#local-development-setup)
- [Composer version drift](#composer-version-drift)
- [Code style](#code-style)
- [Testing](#testing)
- [Pull Request checklist](#pull-request-checklist)
- [Reporting bugs / requesting features](#reporting-bugs--requesting-features)
- [Reporting security vulnerabilities](#reporting-security-vulnerabilities)
- [License](#license)

---

## Code of conduct

Be kind, be professional, and remember that this project handles **patient
health information**. We follow the
[Contributor Covenant v2.1](https://www.contributor-covenant.org/version/2/1/code_of_conduct/).
Violations may be reported to `cus.samnang@gmail.com`.

---

## Branching model

We use a simplified **GitHub Flow**:

```
main      ──●──────●──────●──────●─────────►  (always deployable)
              \      \      \      \
               feat/x  fix/y  chore/z  docs/w
```

- `main` is the only long-lived branch; it must always be green and deployable.
- Open every change as a Pull Request from a short-lived branch.
- Branch names should follow `<type>/<short-description>`, e.g.
  `feat/audit-trail`, `fix/login-redirect`, `chore/composer-update`,
  `docs/iso-mapping`.
- **Never push directly to `main`.** Branch protection (required reviews + CI
  green) is enabled.

---

## Change control (ISO 9001 §8.5.6)

ISO 9001 §8.5.6 (*Control of changes*) requires that every change to a
process or product is *reviewed*, *approved*, and *documented* with enough
evidence to reconstruct the rationale later. We translate that into Pull
Request hygiene as follows:

Every Pull Request **must** contain, in its description:

1. **Why** — the problem being solved or the requirement being implemented.
2. **What** — the change at a high level (which modules, which tables,
   which routes).
3. **How** — implementation notes and any deviation from existing patterns.
4. **Risk & rollback** — what can break, and how to revert.
5. **Validation** — manual test steps performed and/or automated tests added.
6. **Linked artefacts** — Issue, audit-report section, ISO clause when
   relevant.

A PR template at [`.github/PULL_REQUEST_TEMPLATE.md`](.github/PULL_REQUEST_TEMPLATE.md)
enforces this.

Pull Requests touching **clinical data models** (Customer, Document, Bio,
BioDetail, Rx, Hospital*, Order, Schedule) require **at least one reviewer
with clinical/lab process knowledge** to approve.

---

## Commit messages

We follow **[Conventional Commits 1.0](https://www.conventionalcommits.org/en/v1.0.0/)**:

```
<type>(<scope>)<!>: <short summary>

<body>

<footer>
```

| Type      | When to use                                        |
|-----------|----------------------------------------------------|
| `feat`    | A new feature                                       |
| `fix`     | A bug fix                                           |
| `docs`    | Documentation only                                  |
| `style`   | Formatting, missing semicolons, etc. (no code)      |
| `refactor`| Code change that neither fixes a bug nor adds a feature |
| `test`    | Adding or correcting tests                          |
| `chore`   | Build, CI, deps, tooling                            |
| `perf`    | Performance improvement                             |
| `revert`  | Reverts a previous commit                           |

Use `!` after the type/scope (or a `BREAKING CHANGE:` footer) to signal a
breaking change.

Example:

```
feat(bio): add electronic-signature workflow for result release

Implements ISO 15189 §5.9 (release of results) by introducing
states draft → reviewed → released → amended on Bio results.
A released result becomes immutable; amendments are append-only
and require justification.

Refs: docs/audit-report.md (Phase 2)
```

---

## Local development setup

See [README.md → Quick start](README.md#quick-start).

In short:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run dev
php artisan serve
```

### Pre-commit hook (optional but recommended)

Once we add `laravel/pint` to dev dependencies (planned in Phase 0 of the
audit report), enable a git pre-commit hook:

```bash
cat > .git/hooks/pre-commit <<'EOF'
#!/usr/bin/env bash
set -e
./vendor/bin/pint --test
php artisan test --parallel
EOF
chmod +x .git/hooks/pre-commit
```

> A managed solution (e.g. `brianium/paratest` + `captainhook`) will be added
> in a later phase.

---

## Composer version drift

> ⚠️ As of the Phase 0 hygiene PR, **`composer.json` and `composer.lock`
> are not in sync**. The manifest declares `laravel/framework: ^12.0`, but
> the lock-file is from a Laravel-10 install.

There are two acceptable resolutions, and the decision is the maintainer's:

1. **Stay on Laravel 10 for now** *(safer, smaller PR)*
   - Change `composer.json` `laravel/framework` to `^10.48`
   - Run `composer update --no-scripts laravel/framework`
   - Run full test + manual smoke test
   - Plan the 10 → 12 upgrade as a dedicated PR (read the official Laravel
     upgrade guides for 10 → 11 and 11 → 12 in order).

2. **Upgrade to Laravel 12 now** *(more work, dedicated PR)*
   - Follow [Laravel 10 → 11](https://laravel.com/docs/11.x/upgrade) then
     [Laravel 11 → 12](https://laravel.com/docs/12.x/upgrade) upgrade guides.
   - Touch every required signature change (skeleton refactor, middleware,
     bootstrap/, etc.).
   - Bump PHP minimum, regenerate `composer.lock`, refresh `vendor/`.
   - Run full test + manual smoke test.

Either way, the change must be its own PR (no piggy-backing on feature work).
Until then, do **not** run `composer install` against the current
`composer.json` blindly — it will reject the lock-file.

---

## Code style

We follow **PSR-12** with Laravel-flavored Pint defaults
(see [`pint.json`](pint.json) once Phase 0 ships it).

```bash
./vendor/bin/pint            # auto-fix
./vendor/bin/pint --test     # CI mode (no writes, exit ≠ 0 on issues)
```

Other conventions:

- Indentation: 2 spaces (existing repo style); enforced via
  [`.editorconfig`](.editorconfig).
- Blade: `{{ }}` for escaped output, `{!! !!}` only when the content is
  *trusted HTML* and `Purifier::clean()`'ed.
- No mass-assignment via `$request->all()`; use FormRequest classes once they
  arrive in Phase 1.
- All clinical-data tables must (post-Phase 2) carry `created_by`,
  `updated_by`, `deleted_by` and `SoftDeletes`.

---

## Testing

```bash
php artisan test
```

Until the test suite is expanded (Phase 4), please:

- Add at least one **Feature test** per new controller method.
- Add at least one **Unit test** per new service method.
- Document any manual test steps in the PR description under *Validation*.

---

## Pull Request checklist

Before requesting review, make sure:

- [ ] Branch is up-to-date with `main` (rebase or merge).
- [ ] CI is green (Pint + PHPUnit + composer-validate).
- [ ] PR description follows the [Change control](#change-control-iso-9001-856) format.
- [ ] No `.env`, no `vendor/`, no `node_modules/`, no real patient images committed.
- [ ] No secrets / API keys / passwords in code or commit messages.
- [ ] New / changed routes are covered by tests **or** documented manual test
  steps.
- [ ] Migrations are reversible (`down()` is implemented and tested).
- [ ] User-facing strings are translated (`__()` / `@lang()`) for **both**
  English and ខ្មែរ.
- [ ] `CHANGELOG.md` updated under `## [Unreleased]` (semver bucket).

---

## Reporting bugs / requesting features

Open an issue using one of the templates in
[`.github/ISSUE_TEMPLATE/`](.github/ISSUE_TEMPLATE/):

- **Bug report** — include reproduction steps, expected vs. actual behaviour,
  environment.
- **Feature request** — describe the user problem, not the solution.
- **ISO non-conformance** — for findings against ISO 9001 / ISO 15189 (use this
  if you spot a quality-system gap).

---

## Reporting security vulnerabilities

**Never** open a public issue for a security bug. Follow
[`SECURITY.md`](SECURITY.md).

---

## License

By contributing, you agree that your contributions will be licensed under the
[MIT License](LICENSE).
