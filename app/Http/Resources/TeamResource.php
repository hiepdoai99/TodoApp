<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_by' => new UserResource($this->whenLoaded('created_by_user')),
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
