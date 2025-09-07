<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StructureResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'code' => $this->code,
            'services' => ServiceResource::collection($this->whenLoaded('services')),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
    public function with($request): array
    {
        return [
            'meta' => [
                'status' => 'success',
                'message' => 'Structure retrieved successfully',
            ],
        ];
    }
}
