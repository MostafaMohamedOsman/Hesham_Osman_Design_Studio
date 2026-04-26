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
            'project_name'=>$this->name,
            'project_description'=>$this->desc,
            'project_image'=>$this->images->map(function ($image) {
            return ['image'=>url("dist/img/images/$image->img")];
        }),
        ];
    }
}
