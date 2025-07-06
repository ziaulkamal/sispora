<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProbabilityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'label' => strtoupper($this->label),
            'description' => $this->description,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y H:i') . ' WIB',
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('d F Y H:i') . ' WIB',
        ];
    }
}
