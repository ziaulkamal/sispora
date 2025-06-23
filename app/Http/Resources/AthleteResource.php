<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AthleteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sportsSubId' => $this->sportsSubId,
            'person' => new PersonResource($this->whenLoaded('person')),
            'kontingen' => new KontingenResource($this->whenLoaded('kontingen')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
