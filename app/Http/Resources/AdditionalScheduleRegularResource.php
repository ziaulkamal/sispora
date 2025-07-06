<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdditionalScheduleRegularResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'schedulesId' => $this->schedulesId,
            'kontingenId' => $this->kontingenId,
            'kontingenName' => $this->kontingen?->regency?->name ?? '-',
            'typeScore' => $this->typeScore,
            'score' => $this->score,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y H:i') . ' WIB',
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('d F Y H:i') . ' WIB',
        ];
    }
}