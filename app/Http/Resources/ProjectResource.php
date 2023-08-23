<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'team' => new TeamResource($this->whenLoaded('team')),
            'created_by' => new UserResource($this->whenLoaded('created_by_user')),
        ];
    }
}
