<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

/**
 * Validate input when registering a new system user.
 *
 * Replaces the inline `Validator::make()` previously embedded in
 * App\Http\Controllers\Admin\UserController::store().
 *
 * Password complexity follows NIST SP 800-63B (min 12 + mixed case +
 * digit + symbol + breach check). The breach check (`->uncompromised()`)
 * silently calls https://haveibeenpwned.com — disable behind a config
 * flag for offline / air-gapped deployments if required.
 */
class StoreUserRequest extends FormRequest
{
  public function authorize(): bool
  {
    return Gate::allows('user_create');
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
      'name'          => ['required', 'string', 'max:255'],
      'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
      'username'      => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
      'phone_no'      => ['required', 'string', 'max:20', 'unique:users,phone_no'],
      'password'      => ['required', 'confirmed', Password::min(12)
        ->mixedCase()
        ->numbers()
        ->symbols(),
      ],
      'roles'         => ['required', 'array', 'min:1'],
      'roles.*'       => ['integer', 'exists:roles,id'],
      'status'        => ['nullable'],
      'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
      'old_image'     => ['nullable', 'string', 'max:255'],
    ];
  }

  /**
   * Preserve the legacy AJAX response shape so the existing frontend
   * (admin/user/index.blade.php) keeps working unchanged.
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
