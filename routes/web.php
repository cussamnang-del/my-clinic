<?php

use App\Http\Controllers\Admin\ProvinceDistrictCommuneVillageController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authentication routes
|--------------------------------------------------------------------------
|
| Auth::routes() registers /login, /register, /password/* etc. Wrapping
| them in a `throttle:login` group enforces a per-email + per-IP rate
| limit on top of Laravel's default throttle, preventing credential
| stuffing / password brute-force.
|
| See App\Providers\RouteServiceProvider::configureRateLimiting().
| Maps to: ISO 27001:2022 A.5.17 (authentication information),
|          OWASP ASVS v4 §2.2 (general authenticator).
*/
Route::middleware(['throttle:login'])->group(function () {
    Auth::routes();
});

Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| Two-Factor Authentication
|--------------------------------------------------------------------------
|
| The setup pages are reachable as soon as the user is authenticated; the
| EnsureTwoFactorVerified middleware (registered on the admin route group)
| then forces the user through the challenge before they can access
| anything else. Setup + challenge routes themselves are exempt from the
| middleware so the user can actually complete the flow.
|
| Login-style throttle is reused so the verify endpoint cannot be brute-
| forced into accepting a TOTP code (≈1M / 30s search space).
|
| Maps to: ISO 27001:2022 A.5.17, NIST SP 800-63B §5.1.4.
*/
Route::middleware(['auth', 'throttle:login'])->prefix('two-factor')->name('two-factor.')->group(function () {
    Route::get('/setup', [TwoFactorController::class, 'showSetup'])->name('setup');
    Route::post('/confirm', [TwoFactorController::class, 'confirmSetup'])->name('confirm');
    Route::get('/challenge', [TwoFactorController::class, 'showChallenge'])->name('challenge');
    Route::post('/verify', [TwoFactorController::class, 'verifyChallenge'])->name('verify');
    Route::post('/disable', [TwoFactorController::class, 'disable'])->name('disable');
});

/*
|--------------------------------------------------------------------------
| Public AJAX endpoints (address pickers, calendar, autocomplete)
|--------------------------------------------------------------------------
|
| These endpoints are reachable without authentication in legacy flows.
| They are rate-limited to make scraping / abuse harder. Auth-gating
| them properly is tracked as a follow-up in audit-report.md (H-5 / M-1).
*/
Route::middleware(['throttle:public'])->group(function () {
    Route::get('/districts', [ProvinceDistrictCommuneVillageController::class, 'district'])
        ->name('districts.index');

    Route::get('/communes', [ProvinceDistrictCommuneVillageController::class, 'commune'])
        ->name('communes.index');

    Route::get('/villages', [ProvinceDistrictCommuneVillageController::class, 'village'])
        ->name('villages.index');

    // Locale switcher — sets the per-session locale.
    Route::get('/locale/{locale}', function (string $locale) {
        // Whitelist supported locales to avoid arbitrary session writes.
        $allowed = ['en', 'km'];
        if (in_array($locale, $allowed, true)) {
            Session::put('locale', $locale);
        }

        return redirect()->back();
    });

    Route::get('full-calendar', [FullCalenderController::class, 'calendar3'])
        ->middleware('auth');
    Route::post('full-calendar/action', [FullCalenderController::class, 'action'])
        ->middleware('auth');

    Route::get('/auto', function () {
        return view('autocomplete');
    });

    Route::get('/get-countries', function (Request $request) {
        $name = strtolower(trim((string) $request->get('name')));
        $fieldName = (string) $request->get('fieldName');
        $allowedFields = ['name', 'id', 'code'];
        if ($fieldName === '' || ! in_array($fieldName, $allowedFields, true)) {
            $fieldName = 'name';
        }

        return DB::table('country')
            ->select('country.*')
            ->whereRaw('LOWER(`'.$fieldName.'`) LIKE ?', ["$name%"])
            ->limit(25)
            ->get();
    });
});
