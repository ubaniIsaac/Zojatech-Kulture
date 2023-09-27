<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'plan',
        'description',
        'price',
        'upload_limit',
        
    ];


    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function scopeActive(): object
    {
        return $this->where('subscription_status', 'active');
    }

    public function scopeInactive(): object
    {
        return $this->where('subscription_status', 'inactive');
    }

    public function scopeFree(): object
    {
        return $this->where('price', 0);
    }

    public function scopePaid(): object
    {
        return $this->where('price', '>', 0);
    }
}
