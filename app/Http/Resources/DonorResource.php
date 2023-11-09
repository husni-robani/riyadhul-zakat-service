<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'house_number' => $this->house_number,
            'total_muzaki' => $this->total_muzaki,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}
