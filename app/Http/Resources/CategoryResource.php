<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'image'=>asset($this->image),
            'subcategories' => CategoryCollection::make($this->whenLoaded('subcategories')),
            // 'subSubCategories' => CategoryCollection::make($this->whenLoaded('subSubCategories')),
            // 'child' => $this->parent_id,
        ];
    }
}
