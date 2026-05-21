---
name: testing-my-clinic
description: Test the my-clinic Laravel application end-to-end. Use when verifying code changes, audit fixes, or new features in the clinic management system.
---

# Testing my-clinic

## Environment Setup

1. Install PHP 8.3 and Composer dependencies:
   ```bash
   composer install
   ```

2. Install frontend dependencies and build:
   ```bash
   npm install && npm run build
   ```

3. Set up SQLite database for local testing:
   ```bash
   touch database/database.sqlite
   cp .env.example .env  # if .env doesn't exist
   # Set DB_CONNECTION=sqlite and DB_DATABASE to absolute path of database.sqlite in .env
   php artisan key:generate
   php artisan migrate --seed
   ```

4. Start the dev server:
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```

## Test Account

- **Email:** superadmin@login.com
- **Password:** See database seeder (`database/seeders/`) for the default superadmin password
- **Role:** Super Admin (full access)

## Important: 2FA Setup

The app may require 2FA setup on first login. When redirected to `/two-factor/setup`:
1. Read the TOTP secret displayed on the page
2. Generate a TOTP code using pyotp: `python3 -c "import pyotp; print(pyotp.TOTP('SECRET_FROM_PAGE').now())"`
3. Enter the code and confirm to proceed to the dashboard

## Shell-Based Tests

### PHPUnit
```bash
php artisan test
# Expected: 55+ tests passing
```

### Pint Code Style
```bash
./vendor/bin/pint --test
# Expected: All files pass
```

## Browser Testing

Key admin pages to verify:
- `/admin/dashboard` - Main dashboard
- `/admin/documents` - Documents list (AJAX-heavy, uses DataTables)
- `/admin/products` - Products list (DataTables)
- `/admin/customers` - Customer management

## Common Pitfalls

- **Rate limiting (429 errors):** Laravel's throttle middleware may block rapid requests. If hit, run `php artisan cache:clear` to reset the rate limiter. Avoid making many curl requests in quick succession.
- **2FA redirect loop:** If the app keeps redirecting to `/two-factor/setup`, the superadmin account might need 2FA enabled. Use pyotp to generate the TOTP code.
- **TOTP secret reading:** The base32 secret on the 2FA page might be hard to read. Use the browser zoom feature to verify characters. Base32 only uses A-Z and 2-7.
- **Session issues with curl:** Laravel sessions may not persist well across curl requests. Prefer browser-based testing for authenticated pages.
- **Vite assets:** Run `npm run build` before testing to ensure frontend assets are compiled. Missing assets will cause broken CSS/JS.

## What to Test After Code Changes

1. **Security fixes:** Verify Gate authorization by checking admin pages load for superadmin but would deny unauthorized users
2. **AJAX changes:** Navigate to Documents and Products pages, verify DataTables load without JS errors
3. **Frontend fixes:** Check page titles, asset paths in view-source, CSS loading
4. **Config changes:** Grep config files directly (e.g., `grep 'password_timeout' config/auth.php`)
5. **Model changes:** Verify $fillable arrays via source file inspection
