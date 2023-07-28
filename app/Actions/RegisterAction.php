<?php

namespace App\Actions;

use App\Enums\RolesEnum;
use App\Enums\UserTypesEnum;
use App\Jobs\SendEmail;
use App\Models\Role;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use Spatie\QueueableAction\QueueableAction;
use Illuminate\Auth\Events\Registered;


class RegisterAction
{
    use QueueableAction;

    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(array $dataUser)
    {
        $dataUser['password'] = Hash::make($dataUser['password']);
        $dataUser['user_type'] = (string)UserTypesEnum::member();
        $dataUser['roles'] = (string)RolesEnum::member();

        $user = new User();
        DB::beginTransaction();
        try {
            if ($user->fill($dataUser)->save() && !empty($dataUser['roles'])) {
                $user->assignRole($dataUser['roles']);
                $role = Role::findByName($dataUser['roles']);
                $user->givePermissionTo($role->getAllPermissions());
            }

            $token = Str::random(10);
            UserVerify::create([
                'user_id' => $user->id,
                'token' => $token
            ]);
            DB::commit();

            SendEmail::dispatch($user,$token);

//            Mail::send('emails.index', ['token' => $token, 'user' => $user], function($message) use($user){
//                $message->to($user->email);
//                $message->subject('Email Verification Mail');
//            });

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            DB::rollBack();
        }
        return $user;
    }
}
