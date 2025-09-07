<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'structure_id' => $this->structure_id,
            'nom' => $this->nom,
            'code' => $this->code,
            'structure' => new StructureResource($this->whenLoaded('structure')),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
    public function with($request): array
    {
        return [
            'meta' => [
                'status' => 'success',
                'message' => 'Service retrieved successfully',
            ],
        ];
    }
}
