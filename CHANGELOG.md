# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

This changelog also serves as evidence of *control of documented information*
required by ISO 9001:2015 §7.5.

---

## [Unreleased]

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
