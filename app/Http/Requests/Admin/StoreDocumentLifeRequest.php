<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentLifeRequest extends FormRequest
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
            'type_id' => ['required', 'integer'],
            'type_name' => ['required', 'string', 'max:255'],
            'type_desr' => ['required', 'string'],
            'num' => ['required', 'integer'],
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
