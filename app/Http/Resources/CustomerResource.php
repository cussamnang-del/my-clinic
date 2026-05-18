<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Stable, controllable JSON shape for a Customer.
 *
 * The legacy admin AJAX endpoints currently dump whatever Eloquent
 * decides to serialize, which leaks columns to the front-end and
 * makes it dangerous to add new columns to the table. Funnel every
 * new endpoint through a resource so we control the wire format.
 */
class CustomerResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'mrn' => $this->mrn,
            'customer_code' => $this->customer_code,
            'name' => $this->name,
            'sex' => $this->sex,
            'age' => $this->age,
            'dob' => optional($this->dob)?->format('Y-m-d'),
            'phone_no' => $this->phone_no,
            'nationality' => $this->nationality,
            'register_date' => optional($this->register_date)?->format('Y-m-d'),
            'address' => $this->whenLoaded('province', fn () => $this->address),
            'created_at' => optional($this->created_at)?->toIso8601String(),
            'updated_at' => optional($this->updated_at)?->toIso8601String(),
        ];
    }
}
