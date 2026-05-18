<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type_name' => $this->type_name ?? $this->name ?? null,
            'item_group_id' => $this->item_group_id,
        ];
    }
}
