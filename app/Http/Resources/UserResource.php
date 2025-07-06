<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'status' => $this->status,
            'last_login' => $this->last_login,
            'people' => $this->whenLoaded('people'),
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y H:i') . ' WIB',
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('d F Y H:i') . ' WIB',
        ];
    }
}
