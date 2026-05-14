# Security Policy

## Supported versions

| Branch  | Status     | Receives security fixes |
| ------- | ---------- | ----------------------- |
| `main`  | Active     | ✅ Yes                  |
| Other   | Unsupported| ❌ No                   |

`my-clinic` is pre-release software undergoing hardening toward ISO 9001:2015
and ISO 15189:2022 compliance. Until a tagged `v1.0.0` release is published,
only the `main` branch is supported.

---

## Reporting a vulnerability

**Please do _not_ open a public GitHub issue.**

If you believe you have found a security vulnerability in `my-clinic`,
please report it privately by email to **`cus.samnang@gmail.com`** with the
subject line:

> `[SECURITY] my-clinic — <short description>`

Include in your report:

1. A description of the vulnerability and its impact.
2. Steps to reproduce (proof-of-concept, screenshots, request/response logs).
3. The affected commit SHA or version.
4. Your contact details and whether you wish to be credited.

You will receive an acknowledgement within **5 business days**. We aim to
provide an initial assessment within **10 business days** and a fix or
mitigation timeline thereafter.

Please do not disclose the vulnerability publicly until we have released a
patch or 90 days have passed since your initial report, whichever comes
first.

---

## Known issues (historical)

The repository's initial public commit (`3f0b20e`, "first commit") contained
the following items that have **subsequently been removed from the tracking
list** by the Phase 0 hygiene PR but **may still exist in git history**:

- `.env` containing a real `APP_KEY`
- `vendor/` (~72 MB)
- `node_modules/` (~51 MB)
- `public/uploads/` (real patient/customer images)
- `CTempcomposer_output.txt` (build artefact)

### What to do if `APP_KEY` was leaked

Because Laravel uses `APP_KEY` to encrypt session cookies, signed URLs, and
encrypted column casts, a leaked `APP_KEY` must be treated as a **compromise
of all encrypted data**.

Action checklist:

1. **Rotate `APP_KEY` immediately** on every environment:
   ```bash
   php artisan key:generate --force
   ```
2. **Re-encrypt** any data stored with `Crypt::encryptString()` / encrypted
   model casts — the old key must be used to decrypt, then the new key to
   re-encrypt.
3. **Invalidate all sessions** (clears cookies signed with the old key):
   ```bash
   php artisan session:flush     # or truncate the sessions table / Redis key
   php artisan optimize:clear
   ```
4. **Rotate every credential ever present in the committed `.env`**:
   - `DB_*`
   - `MAIL_*`
   - `PUSHER_*` / `BROADCAST_*`
   - `AWS_*`
5. **Purge `.env` from git history** (this rewrites history — coordinate with
   every collaborator):
   ```bash
   # Recommended: https://github.com/newren/git-filter-repo
   git filter-repo --invert-paths --path .env
   git push --force-with-lease origin main
   ```

> Until step 5 is performed, the leaked `APP_KEY` remains retrievable by
> anyone who can clone the repository.

---

## Disclosure policy

We follow **Coordinated Vulnerability Disclosure (CVD)**. After a fix is
released:

1. A `SECURITY` advisory is published on GitHub.
2. A `CVE` is requested when the vulnerability affects the security of
   patient data or user accounts.
3. Affected operators are notified via the contact email on file.
4. A post-mortem is added to the [`CHANGELOG.md`](CHANGELOG.md).

This policy aligns with ISO/IEC 29147 (Vulnerability Disclosure) and the
ISO 9001:2015 §10.2 *Nonconformity and corrective action* clause.
