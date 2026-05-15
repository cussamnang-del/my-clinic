<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentLifeDetailRequest extends FormRequest
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
            'document_lives_id' => ['required', 'integer'],
            'colfield' => ['required', 'string', 'max:255'],
            'coldesr' => ['required', 'string'],
            'coldate' => ['required', 'date'],
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
