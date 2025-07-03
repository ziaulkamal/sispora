<?php

namespace App\Http\Resources;

use App\Models\Athlete;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PersonResource extends JsonResource
{
    protected $forEdit = false;

    public function forEdit($value = true)
    {
        $this->forEdit = $value;
        return $this;
    }

    public function toArray(Request $request): array
    {
        // Daftar label agama
        $religions = [
            1 => 'ISLAM',
            2 => 'KRISTEN KATOLIK',
            3 => 'KRISTEN PROTESTAN',
            4 => 'HINDU',
            5 => 'BUDDHA',
            6 => 'KONGHUCU',
        ];
        if ($this->forEdit) {
            return [
                'id' => $this->id,
                'fullName' => $this->fullName,
                'age' => $this->age,
                'birthdate' => $this->birthdate,
                'identityNumber' => $this->identityNumber,
                'familyIdentityNumber' => $this->familyIdentityNumber,
                'gender' => $this->gender,
                'streetAddress' => $this->streetAddress,
                'religion' => $this->religion,
                'provinceId' => $this->provinceId,
                'regencieId' => $this->regencieId,
                'districtId' => $this->districtId,
                'villageId' => $this->villageId,
                'kontingen' => $this->kontingenId,
                'phoneNumber' => $this->phoneNumber,
                'email' => $this->email,
                'height' => $this->height,
                'weight' => $this->weight,
                'documentId' => $this->documentId,
                'userId' => $this->userId,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,

                // opsional: relasi document
                'probability' => new ProbabilityResource($this->whenLoaded('probability')),
                'document' => new DocumentResource($this->whenLoaded('document')),
            ];
        }

        return [
            'id' => $this->id,
            'fullName' => strtoupper($this->fullName),
            'age' => $this->age . ' TAHUN',
            'birthdate' => Carbon::parse($this->birthdate)->translatedFormat('d F Y'),
            'identityNumber' => strtoupper($this->identityNumber),
            'familyIdentityNumber' => strtoupper($this->familyIdentityNumber),
            'gender' => strtoupper($this->gender) === 'MALE' ? 'LAKI-LAKI' : 'PEREMPUAN',
            'streetAddress' => strtoupper($this->streetAddress),
            'religion' => $religions[$this->religion] ?? 'TIDAK DIKETAHUI',
            'province' => strtoupper(optional($this->province)->name),
            'regency' => strtoupper(optional($this->regencie)->name),
            'district' => strtoupper(optional($this->district)->name),
            'village' => strtoupper(optional($this->village)->name),
            'kontingen' => strtoupper(optional($this->kontingen)->name),
            'phoneNumber' => $this->phoneNumber,
            'email' => $this->email,
            'height' => $this->height ? $this->height . ' Cm' : null,
            'weight' => $this->weight ? $this->weight . ' Kg' : null,
            'userId' => $this->userId,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y H:i') . ' WIB',
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('d F Y H:i') . ' WIB',
            'hasDocument' => !is_null($this->documentId),
            'isAthlete' => $this->checkIfAthlete(),

            'sports' => $this->athletes->map(function ($athlete) {
                return $athlete->sportsSub->name ?? null;
            })->filter()->unique()->values()->toArray(),

            'probability' => new ProbabilityResource($this->whenLoaded('probability')),
            'document' => new DocumentResource($this->whenLoaded('document')),

            'athletes' => $this->whenLoaded('athletes', function () {
                return $this->athletes->map(function ($athlete) {
                    return [
                        'id' => $athlete->id,
                        'sportsSub' => [
                            'id' => $athlete->sportsSub->id ?? null,
                            'name' => $athlete->sportsSub->name ?? null,
                            'sport' => [
                                'id' => $athlete->sportsSub->sport->id ?? null,
                                'name' => $athlete->sportsSub->sport->name ?? null,
                            ],
                        ],
                    ];
                });
            }),
        ];


    }

    /**
     * Cek apakah orang ini sudah terdaftar sebagai atlet
     */
    protected function checkIfAthlete(): bool
    {
        return Athlete::where('peopleId', $this->id)->exists();
    }
}
