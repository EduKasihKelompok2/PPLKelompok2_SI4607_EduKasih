<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimedReward extends Model
{
    protected $table = "claimed_rewards";
    protected $fillable = [
        'user_id',
        'reward_id',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * Get the user who claimed this reward.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Get the reward that was claimed.
     */
    public function reward()
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }
}
