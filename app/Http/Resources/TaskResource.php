<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'image' => Storage::url($this->image),
            'assignor' => new UserResource($this->whenLoaded('user')),
            'assignee' => new UserResource($this->whenLoaded('assignee')),
            'status' =>  $this->status,
            'project' => new ProjectResource($this->whenLoaded('project')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
