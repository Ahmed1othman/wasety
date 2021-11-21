<?php

namespace App\Http\Resources;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'dues' => $this->dues,
            'title' => $this->title,
            'status' => $this->status,
            'details' => $this->details,
            'user' =>  new UserResource($this->user()->first()),
            'project' =>  new ProjectResource($this->project()->first()),

            'create_dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ],
            'update_dates' => [
                'updated_at_human' => $this->updated_at->diffForHumans(),
                'updated_at' => $this->updated_at
            ],
        ];
    }

}
