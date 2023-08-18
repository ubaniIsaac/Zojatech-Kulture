<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['name'];

    /**
     * Get the beats associated with the genre.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Beat>
     */
     public function beats(): HasMany
     {
         return $this->hasMany(Beat::class);
     }
}
