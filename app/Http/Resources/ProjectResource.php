<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Project name'=>$this->name,
            'Project description'=>$this->desc,
            'Project image'=>$this->images->map(function ($image) {
            return ['image'=>url("dist/img/images/$image->img")];
        }),
        ];
    }
}
