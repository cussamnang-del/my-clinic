<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public static function rulesFor(): array
    {
        return [
            'p_name' => 'required|string|max:255',
            'p_code' => 'required|string|max:100',
            'unit' => 'required|string|max:100',
            'strength' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:4096',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return static::rulesFor();
    }
}
