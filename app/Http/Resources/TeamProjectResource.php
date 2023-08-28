<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamProjectResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'team'=>$this->team,
            'project'=>$this->project,
        ];
    }
}
