<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeriesGroupMatchSpecialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kontingenId' => $this->kontingenId,
            'sports_subs_id' => $this->sports_subs_id,
            'sportId' => $this->sportId,
            'group' => $this->group,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'sport' => new SportResource($this->whenLoaded('sport')),
            'kontingen' => new KontingenResource($this->whenLoaded('kontingen')),
        ];
    }
}
