<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => $this->address->full_name,
            'order_number' => $this->order_number,
            'city' => $this->address->city,
            'address' => $this->address->address,
            // 'order_type' => $this->order_type,
            'payment_method' => $this->payment_method,
            'total' => $this->total,
        ];
    }
}
