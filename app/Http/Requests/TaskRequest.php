<?php

namespace App\Http\Requests;

use App\Traits\HnxRequest;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    use HnxRequest;

    protected function getModel() : string
    {
        return 'Task';
    }
}
