<?php

namespace App\Http\Resources\WikiPage;

use Illuminate\Http\Resources\Json\JsonResource;

class WikiPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'thumb' => $this->pageThumb,
            'title' => $this->title,
            'slug' => $this->slug,
            'menu_level' => $this->menu_level,
            'description' => $this->description,
            'updated_at' => $this->updated_at,
        ];
    }
}
