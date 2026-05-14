<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;

/**
 * Validate input when updating an existing customer record.
 *
 * Used by the same controller action (store) as StoreCustomerRequest
 * because the existing UI submits create + update via the same endpoint
 * with an `object_id` flag — see CustomerController::store().
 */
class UpdateCustomerRequest extends FormRequest
{
  public function authorize(): bool
  {
    return Gate::allows('customer_edit');
  }

  /**
   * @return array<string, mixed>
   */
  public function rules(): array
  {
    return self::rulesFor();
  }

  /**
   * Static helper so the legacy controller can share the same rules
   * without needing to inject this FormRequest as a method parameter.
   *
   * @return array<string, mixed>
   */
  public static function rulesFor(): array
  {
    return [
      'name'          => ['sometimes', 'required', 'string', 'max:255'],
      // See StoreCustomerRequest::rulesFor() for why this is not constrained.
      'sex'           => ['sometimes', 'required', 'string', 'max:50'],
      'age'           => ['sometimes', 'required', 'string', 'max:20'],
      'dob'           => ['sometimes', 'required', 'date', 'before_or_equal:today'],
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
   * Match the legacy AJAX response contract.
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
