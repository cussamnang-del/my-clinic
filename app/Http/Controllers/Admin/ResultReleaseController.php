<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BioDetail;
use App\Services\ResultReleaseService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Endpoints for transitioning a single lab result through the
 * release workflow. Each transition requires the user to re-enter
 * their password — the password serves as the "electronic signature"
 * mandated by ISO 15189:2022 §7.3.7.4 / 21 CFR Part 11.
 *
 * Routes (registered in routes/admin.php):
 *   POST /admin/results/{biodetail}/submit
 *   POST /admin/results/{biodetail}/review
 *   POST /admin/results/{biodetail}/release
 *   POST /admin/results/{biodetail}/amend
 */
class ResultReleaseController extends Controller
{
    public function __construct(private readonly ResultReleaseService $service) {}

    public function submit(Request $request, BioDetail $biodetail): RedirectResponse
    {
        $this->requireSignature($request);

        return $this->run(fn () => $this->service->submit($biodetail, $request->user()));
    }

    public function review(Request $request, BioDetail $biodetail): RedirectResponse
    {
        $this->requireSignature($request);

        return $this->run(fn () => $this->service->review($biodetail, $request->user()));
    }

    public function release(Request $request, BioDetail $biodetail): RedirectResponse
    {
        $this->requireSignature($request);

        return $this->run(fn () => $this->service->release($biodetail, $request->user()));
    }

    public function amend(Request $request, BioDetail $biodetail): RedirectResponse
    {
        $data = $request->validate([
            'result' => ['required', 'string', 'max:255'],
            'reason' => ['required', 'string', 'min:5', 'max:512'],
            'signature_password' => ['required', 'string'],
        ]);

        $this->requireSignature($request);

        return $this->run(fn () => $this->service->amend(
            $biodetail,
            $request->user(),
            $data['result'],
            $data['reason'],
        ));
    }

    /**
     * Validates the `signature_password` field against the current user's
     * password. Throws a ValidationException scoped to that field so the
     * Blade form shows a usable error instead of a 500.
     */
    private function requireSignature(Request $request): void
    {
        $request->validate([
            'signature_password' => ['required', 'string'],
        ]);

        $user = Auth::user();

        if (! $user || ! Hash::check($request->input('signature_password'), $user->getAuthPassword())) {
            throw ValidationException::withMessages([
                'signature_password' => __('The signature password does not match our records.'),
            ]);
        }
    }

    /**
     * Convert DomainException (from the service) into a 422 redirect with
     * a flashed error message so the legacy Blade flash flow keeps working.
     */
    private function run(callable $callable): RedirectResponse
    {
        try {
            $callable();
        } catch (DomainException $e) {
            return back()->withErrors(['workflow' => $e->getMessage()])->withInput();
        }

        return back()->with('success', __('Result workflow updated.'));
    }
}
