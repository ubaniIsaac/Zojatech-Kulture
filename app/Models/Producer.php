<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producer extends User
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
      
    ];

    protected $fillable = [
      

    ];

    /**
     * Get the user that owns the producer.
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function beats()
    {
        return $this->hasMany(Beat::class);
    }

}
