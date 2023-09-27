<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Artiste;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Arr;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'confirm_password',
        'user_type',
        'profile_picture',
        'device_id',
        'referral_code',
        
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
        'confirm_password' => 'hashed'
    ];

    /**
     * Generate token based on user Type
     */

    public function generateToken(): string
    {
        if (Str::contains($this->email, 'zojatech.com')) {

            $token = $this->createToken($this->email, ['admin'])->accessToken;
        } else {
            $token = $this->createToken($this->email, [$this->user_type])->accessToken;
        }

        return $token;
    }

    /**
     * Get the producer associated with the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Producer>
     */
    public function producers(): HasOne
    {
        return $this->hasOne(Producer::class);
    }


    /**
     * Get the artiste associated with the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Artiste>
     */

    public function artistes(): HasOne
    {
        return $this->hasOne(Artiste::class);
    }


    /**
     * Get the referral associated with the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Referral>
     */

    public function referral_details(): HasOne
    {
        return $this->hasOne(Referral::class);
    }


    /**
     * Get the cart associated with the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Cart>
     */

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }   


    public function savedBeats()
    {
        return $this->belongsToMany(Beat::class, 'save_for_later', 'user_id', 'beat_id');
    }

}
