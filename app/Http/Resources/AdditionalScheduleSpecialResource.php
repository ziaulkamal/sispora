<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AdditionalScheduleSpecialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'schedulesId' => $this->schedulesId,
            'match' => $this->translateMatch(),
            'group' => $this->group,
            'kontingenId' => $this->kontingenId,
            'kontingenName' => $this->kontingen?->regency?->name ?? '-',
            'score' => $this->score,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y H:i') . ' WIB',
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('d F Y H:i') . ' WIB',
        ];
    }

    private function translateMatch(): string
    {
        return match ($this->match) {
            'qualified' => 'Penyisihan',
            'group'     => 'Grup',
            'grandfinal' => 'Grand Final',
            default     => '-',
        };
    }
}
