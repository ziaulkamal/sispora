<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KontingenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'province_id' => $this->province_id,
            'regencies_id' => $this->regencies_id,
            'regency_name' => $this->regency ? $this->regency->name : null, // ini penting
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y H:i') . ' WIB',
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('d F Y H:i') . ' WIB',
        ];
    }
}
