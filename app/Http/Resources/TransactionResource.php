<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "donor_name" => $this->donor->name,
            "donation_type" => $this->donation_type,
            "payment_method" => $this->payment_method,
            "total_money" => $this->total_money,
            "total_good" => $this->total_good,
            "status" => $this->status
        ];
    }
}
