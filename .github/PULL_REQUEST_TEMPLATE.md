<!--
ISO 9001:2015 §8.5.6 "Control of changes" requires every change to be
reviewed, approved, and documented. Please fill in every section below.
Empty sections will be a reviewer-blocker.
-->

## Why
<!-- The problem being solved, or the requirement being implemented.
     Link issues with "Closes #NN" / "Refs #NN". -->


## What
<!-- The change at a high level — which modules, tables, routes, views. -->


## How
<!-- Implementation notes, deviations from existing patterns, design choices. -->


## Risk & rollback
<!-- What can break? How do we revert if it does?
     Include any data-migration considerations. -->


## Validation
<!-- Manual test steps performed, screenshots, and/or automated tests added.
     Mark each item with [x] when done. -->

- [ ] Local PHPUnit suite passes (`php artisan test`)
- [ ] Linter passes (`./vendor/bin/pint --test`)
- [ ] Manually tested the happy path (describe steps below)
- [ ] Manually tested at least one failure / edge case
- [ ] No regressions on touched pages (smoke-checked)


## ISO / Audit references
<!-- If this PR addresses an item from docs/audit-report.md or a specific
     ISO 9001 / ISO 15189 clause, link it here. -->


## Checklist

- [ ] Branch name follows `<type>/<short-description>` (`feat/`, `fix/`, `chore/`, …)
- [ ] Commit messages follow Conventional Commits
- [ ] No `.env`, `vendor/`, `node_modules/`, real patient data, or secrets in the diff
- [ ] Migrations are reversible (`down()` implemented)
- [ ] User-facing strings translated (`en` + `km`)
- [ ] `CHANGELOG.md` updated under `## [Unreleased]`
- [ ] PR description filled in completely (none of the sections above are empty)
