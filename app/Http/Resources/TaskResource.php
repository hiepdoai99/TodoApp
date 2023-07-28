<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'assignor' => new UserResource($this->whenLoaded('user')),
            'assignee' => new UserResource($this->whenLoaded('assignee')),
            'status' =>  new StatusResource($this->whenLoaded('status')),
            'project' => new ProjectResource($this->whenLoaded('project')),
        ];
    }
}
