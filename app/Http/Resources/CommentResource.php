<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'task' => new TaskResource($this->whenLoaded('task')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
