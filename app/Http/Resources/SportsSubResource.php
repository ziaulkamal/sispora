<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SportsSubResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'         => $this->id,
            'sportId'    => $this->sportId,
            'name'       => $this->name,
            'label'      => $this->label,
            'userId'     => $this->userId,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sport'      => $this->whenLoaded('sport', function () {
                return [
                    'id'   => $this->sport->id,
                    'name' => $this->sport->name,
                ];
            }),
        ];
    }
}
