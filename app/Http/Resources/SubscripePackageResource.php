<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscripePackageResource extends JsonResource
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
            'package' => new PackageResource($this->package()->first()),
            'user' => new UserResource($this->user()->first()),
            'active' => $this->active,
            'completed_adds' => $this->completed_adds,
            'status' => $this->status,

        ];
    }
}
