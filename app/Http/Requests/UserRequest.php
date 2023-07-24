<?php

namespace App\Http\Requests;

use App\Enums\RolesEnum;
use App\Traits\HnxRequest;
use App\Enums\UserTypesEnum;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    use HnxRequest;

    protected function getModel() : string
    {
        return 'User';
    }

//    protected function prepareForAuthorize()
//    {
//        if ($this->has('user_type')) {
//            if ($this->user_type !== (string)UserTypesEnum::member()) {
//                $this->enumClass = '\\App\\Enums\\PermissionsEnum::customer';
//            }
//        }
//    }
//    protected function prepareForValidation()
//    {
//        if (!$this->has('user_type')) {
//            $this->merge([
//                'user_type' => (string)UserTypesEnum::member(),
//            ]);
//        } else if ($this->user_type === (string)UserTypesEnum::member()) {
//            $this->merge([
//                'status' => 1
//            ]);
//        }
//        if (!$this->has('roles')) {
//            $this->merge([
//                'roles' => (string)RolesEnum::member(),
//            ]);
//        }
//    }

}
