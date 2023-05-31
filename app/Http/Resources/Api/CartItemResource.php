<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => $this->user->name,
            'product' => $this->product->name,
            'size' => $this->sizes->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->price * $this->quantity,
            'image' => asset($this->product->image)
        ];
    }
}
