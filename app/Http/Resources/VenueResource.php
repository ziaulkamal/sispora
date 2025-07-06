<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VenueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'location'   => $this->location,
            'latitude'   => $this->latitude,
            'longitude'  => $this->longitude,
            'status'     => $this->status,
            'user_id'    => $this->user_id,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y H:i') . ' WIB',
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('d F Y H:i') . ' WIB',
        ];
    }
}
