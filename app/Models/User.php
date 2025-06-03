<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'photo',
        'nisn',
        'email',
        'password',
        'dob',
        'gender',
        'institution',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the exam sessions for the user.
     */
    public function examSessions()
    {
        return $this->hasMany(ExamSession::class);
    }

    /**
     * Get the forum posts created by the user.
     */
    public function forums()
    {
        return $this->hasMany(Forum::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'users_badge', 'user_id', 'badge_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->unread();
    }

    /**
     * Get the user's initial letters for avatar.
     */
    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Get the rewards claimed by the user.
     */
    public function claimedRewards()
    {
        return $this->belongsToMany(Reward::class, 'claimed_rewards')
            ->withTimestamps();
    }

    /**
     * Check if user has claimed a specific reward.
     */
    public function hasClaimedReward($rewardId)
    {
        return $this->claimedRewards()->where('reward_id', $rewardId)->exists();
    }

    /**
     * Check if user meets the badge requirement for a reward.
     */
    public function canClaimReward(Reward $reward)
    {
        if (!$reward->badge_id) {
            return true; // No badge requirement
        }

        // Get user's highest badge ID
        $userHighestBadgeId = $this->badges()->max('badge_id');

        // If user has no badges, they can't claim rewards that require badges
        if (!$userHighestBadgeId) {
            return false;
        }

        // User can claim if their highest badge ID is >= required badge ID
        return $userHighestBadgeId >= $reward->badge_id;
    }
}
