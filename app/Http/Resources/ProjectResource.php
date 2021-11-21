<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'rate' => $this->rate,
            'image' => $this->image,
            'amount' => $this->amount,
            'status' => $this->status,
            'user'=>new UserResource($this->user()->first()),
        ];
    }
}
