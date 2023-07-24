<?php

namespace App\Http\Resources;

use App\Traits\HnxPaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
{
    use HnxPaginationResource;
}
