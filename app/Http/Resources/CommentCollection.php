<?php

namespace App\Http\Resources;

use App\Traits\HnxPaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
{
    use HnxPaginationResource;
}
