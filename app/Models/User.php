<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Artiste;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Arr;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUlids, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'confirm_password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'confirm_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the producer associated with the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Producer>
     */
    public function producer(): HasOne
    {
        return $this->hasOne(Producer::class);
    }

    /**
     * Get the artiste associated with the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Artiste>
     */

    public function artiste(): HasOne
    {
        return $this->hasOne(Artiste::class);
    }

    public function guardName(): mixed
    {
        return 'api';
    }


    // public function artist(): HasOne
    // {
    //     return $this->hasOne(Artist::class);
    // }
}
