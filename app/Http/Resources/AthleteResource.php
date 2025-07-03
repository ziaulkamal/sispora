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
            'peopleId' => $this->peopleId,
            'sportsSubId' => $this->sportsSubId,
            'sportsSubName' => $this->sportsSub?->name,
            'sportName' => $this->sportsSub?->sport?->name,
        ];
    }
}
