<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'peopleId' => $this->peopleId,
            'imageProfile' => $this->imageProfile,
            'familyProfile' => $this->familyProfile,
            'selfieProfile' => $this->selfieProfile,
            'path' => $this->path,
            'imageId' => $this->imageId,
            'extra' => $this->extra,
            'userId' => $this->userId,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // optional
            'person' => new PersonResource($this->whenLoaded('person')),
        ];
    }
}
