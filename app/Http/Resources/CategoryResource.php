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
            'Category name'=>$this->name,
            'Category description'=>$this->desc,
            'Category image'=>url("dist/img/categories/$this->img"),
        ];
    }
}
