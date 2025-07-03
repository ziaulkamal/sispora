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

            'imageProfile' => [
                'file' => $this->imageProfile,
                'status' => $this->imageProfile_status,
                'note' => $this->imageProfile_note,
            ],

            'identityProfile' => [
                'file' => $this->identityProfile,
                'status' => $this->identityProfile_status,
                'note' => $this->identityProfile_note,
            ],

            'familyProfile' => [
                'file' => $this->familyProfile,
                'status' => $this->familyProfile_status,
                'note' => $this->familyProfile_note,
            ],

            'personalCertificate' => [
                'file' => $this->personalCertificate,
                'status' => $this->personalCertificate_status,
                'note' => $this->personalCertificate_note,
            ],

            'lastDiploma' => [
                'file' => $this->lastDiploma,
                'status' => $this->lastDiploma_status,
                'note' => $this->lastDiploma_note,
            ],

            'supportPdf' => [
                'file' => $this->supportPdf,
                'status' => $this->supportPdf_status,
                'note' => $this->supportPdf_note,
            ],

            'userId' => $this->userId,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // jika relasi person di-load
            'person' => new PersonResource($this->whenLoaded('person')),
        ];
    }
}
