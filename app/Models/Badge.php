<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Badge extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'icon',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_badges')->withTimestamps();
    }

    public static function unlockForUser(User $user, string $badgeKey): void
    {
        $badge = self::where('key', $badgeKey)->first();

        if ($badge && !$user->badges()->where('key', $badgeKey)->exists()) {
            $user->badges()->attach($badge->id, ['unlocked_at' => now()]);
        }
    }
}
