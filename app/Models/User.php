<?php

namespace App\Models;

use App\Enums\RolesEnum;
use App\Enums\UserTypesEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'last_name',
        'first_name',
        'email',
        'password',
        'email_verified_at',
        'remember_token',
        'user_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
//        'user_type' => UserTypesEnum::class,
    ];

    public function getRules() : array
    {
        $model = request()->user;
        return [
            'last_name' => ['sometimes', 'required', 'string'],
            'first_name' => ['sometimes', 'required', 'string'],
            'email' => ['sometimes', 'required', 'email',
                Rule::unique('users', 'email')->where(function ($query) use($model) {
                    return $query->where('id', '!=', $model?->id);
                })
            ],
            'email_verified_at' => ['nullable'],
            'team_id' => ['nullable', 'integer', 'min:1', 'exists:teams,id'],
            'password' => ['sometimes', 'required', 'confirmed', Rules\Password::defaults()],
            'remember_token' => ['nullable'],
            'user_type' => ['nullable', 'enum:'.UserTypesEnum::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', 'boolean'],
            'roles' => ['nullable', 'enum:'.RolesEnum::class],
        ];
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'email'           => $this->email,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];
    }

    public function getNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    public function hasRoleAdmin(): bool
    {
        return $this->hasAnyRole([(string)RolesEnum::root(), (string)RolesEnum::admin()]);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'id');
    }


}
