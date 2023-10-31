<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;


class Flag extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'reason',
        'description',
        'status',
        'type',
        'beat_id',
        'user_id',
        'producer_id'
    ];

    /**
     * Get the beat associated with the flag.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Beat>
     */
    public function beat(): BelongsTo
    {
        return $this->belongsTo(Beat::class);
    }
    
    /**
     * Get the user associated with the flag.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the producer associated with the flag.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Producer>
     */
    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class);
    }
}
