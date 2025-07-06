<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'special_case' => $this->getSpecialCase(),
            'date'       => Carbon::parse($this->date)->translatedFormat('d F Y'),
            'start_time' => $this->start_time . ' WIB',
            'end_time'   => $this->end_time . ' WIB',
            'sports_sub' => (new SportsSubResource($this->whenLoaded('sportsSub')))->toArray(request()),
            'venue'      => (new VenueResource($this->whenLoaded('venue')))->toArray(request()),
            'status'     => $this->status,
            'status_pelaksanaan' => $this->getStatusPelaksanaan(),
            'user_id'    => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'kontingen_count' => $this->getKontingenCount(),
            // Bagian penting: resource dinamis tergantung specialCase
            'additional_schedules' => $this->getAdditionalSchedulesResource(),
        ];
    }

    private function getAdditionalSchedulesResource()
    {
        if ($this->sportsSub && $this->sportsSub->sport && $this->sportsSub->sport->specialCase === 'yes') {
            return AdditionalScheduleSpecialResource::collection(
                $this->whenLoaded('additionalSchedulesSpecial')
            )->toArray(request());
        }

        return AdditionalScheduleRegularResource::collection(
            $this->whenLoaded('additionalSchedulesRegular')
        )->toArray(request());
    }

    private function getKontingenCount(): int
    {
        if ($this->sportsSub && $this->sportsSub->sport && $this->sportsSub->sport->specialCase === 'yes') {
            return $this->additionalSchedulesSpecial ? $this->additionalSchedulesSpecial->count() : 0;
        }

        return $this->additionalSchedulesRegular ? $this->additionalSchedulesRegular->count() : 0;
    }

    private function getStatusPelaksanaan(): string
    {
        $now = Carbon::now();
        $start = Carbon::parse("{$this->date} {$this->start_time}");
        $end = Carbon::parse("{$this->date} {$this->end_time}");

        if ($now->lt($start)) {
            return 'belum dilaksanakan';
        } elseif ($now->between($start, $end)) {
            return 'sedang berlangsung';
        } else {
            return 'selesai';
        }
    }

    private function getSpecialCase(): string
    {
        if ($this->sportsSub && $this->sportsSub->sport) {
            return $this->sportsSub->sport->specialCase === 'yes' ? 'yes' : 'no';
        }

        return 'no';
    }
}
