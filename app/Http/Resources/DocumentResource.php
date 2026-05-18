<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'visit_date' => optional($this->visit_date)?->toIso8601String(),
            'checkout_date' => optional($this->checkout_date)?->toIso8601String(),
            'status' => (bool) $this->status,
            'customer' => CustomerResource::make($this->whenLoaded('customer')),
            'created_at' => optional($this->created_at)?->toIso8601String(),
            'updated_at' => optional($this->updated_at)?->toIso8601String(),
        ];
    }
}
