<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'item_group_id' => ['required', 'integer', 'exists:item_groups,id'],
            'item_type_id' => ['required', 'integer', 'exists:item_types,id'],
            'item_name' => ['required', 'string', 'max:255'],
            'normal_value' => ['required', 'string', 'max:100'],
            'min_value' => ['required', 'string', 'max:100'],
            'max_value' => ['required', 'string', 'max:100'],
            'numset' => ['required', 'numeric'],
            'item_price' => ['required', 'numeric', 'min:0'],
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
