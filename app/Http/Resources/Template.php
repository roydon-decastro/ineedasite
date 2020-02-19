<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Template extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'data' => [
                'template_id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'photo' => $this->photo,
                'livedate' => $this->livedate->format('m/d/Y'),
                'content' => $this->content,
                'last_updated' => $this->updated_at->diffForHumans(),
            ],
            'links' => [
                'self' => $this->path()
            ]
        ];
    }
}
