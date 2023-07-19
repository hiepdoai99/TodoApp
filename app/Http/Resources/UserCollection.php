<?php

namespace App\Http\Resources;

use App\Traits\HnxPaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    use HnxPaginationResource;
}
