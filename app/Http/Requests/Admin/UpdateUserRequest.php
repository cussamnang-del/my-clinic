<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use App\Rules\PreventPasswordReuse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * Validate input when updating an existing system user.
 *
 * The legacy controller (UserController::store) handles both create and
 * update via the same endpoint, but the rules diverge:
 *   - Update DOES NOT require password; if supplied it must still meet
 *     the same complexity as on create.
 *   - email / username / phone_no uniqueness must exclude the current
 *     user id.
 */
class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('user_edit');
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return self::rulesFor((int) $this->input('object_id') ?: null);
    }

    /**
     * Static helper so the legacy controller can share the same rules
     * without needing to inject this FormRequest as a method parameter.
     *
     * @param  int|null  $userId  ID of the user being updated, used to
     *                            exclude them from the unique-column lookups AND to look up the
     *                            user's previous password hashes for the PreventPasswordReuse rule.
     * @return array<string, mixed>
     */
    public static function rulesFor(?int $userId): array
    {
        $user = $userId !== null ? User::find($userId) : null;

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'username' => ['sometimes', 'required', 'string', 'max:50', 'alpha_dash',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'phone_no' => ['sometimes', 'required', 'string', 'max:20',
                Rule::unique('users', 'phone_no')->ignore($userId),
            ],
            'password' => ['nullable', 'confirmed', Password::min(12)
                ->mixedCase()
                ->numbers()
                ->symbols(),
                new PreventPasswordReuse($user),
            ],
            'roles' => ['sometimes', 'required', 'array', 'min:1'],
            'roles.*' => ['integer', 'exists:roles,id'],
            'status' => ['nullable'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'old_image' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Preserve the legacy AJAX response shape.
     */
    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson() || $this->ajax()) {
            throw new HttpResponseException(
                response()->json([
                    'status' => 400,
                    'error' => $validator->errors()->toArray(),
                ])
            );
        }

        parent::failedValidation($validator);
    }
}
