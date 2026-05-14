<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;

/**
 * Validate input when registering a new customer.
 *
 * Replaces the inline `Validator::make()` call previously embedded in
 * App\Http\Controllers\Admin\CustomerController::store().
 *
 * Maps to:
 *   - ISO 9001:2015 §8.5.2 (Identification and traceability)
 *   - audit-report.md → H-3 "No FormRequest validation"
 */
class StoreCustomerRequest extends FormRequest
{
  public function authorize(): bool
  {
    return Gate::allows('customer_create');
  }

  /**
   * @return array<string, mixed>
   */
  public function rules(): array
  {
    return self::rulesFor();
  }

  /**
   * Rule set exposed as a static helper so the legacy controller
   * (CustomerController::store) — which handles BOTH create and update
   * via the same endpoint — can share the same canonical rules.
   *
   * @return array<string, mixed>
   */
  public static function rulesFor(): array
  {
    return [
      'name'          => ['required', 'string', 'max:255'],
      // NOTE: sex is currently stored as a localised display string
      // ("Male" / "Female" / "ប្រុស" / "ស្សី") because the legacy form posts the
      // translated label rather than a code. Phase 2 will migrate to an
      // ISO 5218 numeric code (0/1/2/9) stored in DB + translation
      // applied at render time.
      'sex'           => ['required', 'string', 'max:50'],
      'age'           => ['required', 'string', 'max:20'],
      'dob'           => ['required', 'date', 'before_or_equal:today'],
      'province_id'   => ['nullable', 'integer', 'exists:provinces,id'],
      'district_id'   => ['nullable', 'integer', 'exists:districts,id'],
      'commune_id'    => ['nullable', 'integer', 'exists:communes,id'],
      'village_id'    => ['nullable', 'integer', 'exists:villages,id'],
      'phone_no'      => ['nullable', 'string', 'max:20'],
      'register_date' => ['nullable', 'date'],
      'photo'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
      'status'        => ['nullable'],
      'old_image'     => ['nullable', 'string', 'max:255'],
    ];
  }

  /**
   * Preserve the legacy AJAX response shape
   * `{ status: 400, error: { field: [messages...] } }` so existing frontend
   * code (admin/customer/index.blade.php JS) keeps working unchanged.
   */
  protected function failedValidation(Validator $validator): void
  {
    if ($this->expectsJson() || $this->ajax()) {
      throw new HttpResponseException(
        response()->json([
          'status' => 400,
          'error'  => $validator->errors()->toArray(),
        ])
      );
    }

    parent::failedValidation($validator);
  }
}
