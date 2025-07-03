<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class SportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'imageId'     => $this->imageId,
            'specialCase' => $this->specialCase === 'yes' ? 'khusus' : 'umum',
            'status'      => $this->status,
            'userId'      => $this->userId,
            'created_at'  => $this->created_at,
            'updated_at' => $this->getLastUpdatedAtFormatted(),
            'sub_sports'  => $this->whenLoaded('subSports', function () {
                return $this->subSports->map(function ($sub) {
                    return [
                        'id' => $sub->id,
                        'name' => $sub->name,
                        'label' => $sub->label,
                        'created_at' => $sub->created_at,
                        'updated_at' => $sub->updated_at
                    ];
                });
            }),
        ];
    }

    private function getLastUpdatedAtFormatted(): string
    {
        // Ambil updated_at dari sport
        $mainUpdated = $this->updated_at;

        // Ambil updated_at terakhir dari subSports jika ada
        $subsUpdated = $this->subSports->max('updated_at') ?? null;

        // Ambil tanggal yang paling akhir
        $latest = $subsUpdated && $subsUpdated > $mainUpdated ? $subsUpdated : $mainUpdated;

        return Carbon::parse($latest)->translatedFormat('d F Y H:i') . ' WIB';
    }
}
