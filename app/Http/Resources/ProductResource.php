<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=>$this->name,
            'maincategoy'=>$this->category->name,
            'size'=>$this->size->name,
            'price'=>$this->size->price,
            'image'=>asset($this->image),
            'description'=>$this->description,
        ];
    }
}
