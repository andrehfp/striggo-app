<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest active conversation for a user, or create a new one
     */
    public static function getOrCreateForUser(User $user): self
    {
        $conversation = self::where('user_id', $user->id)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$conversation) {
            $conversation = self::create([
                'user_id' => $user->id,
                'is_active' => true,
            ]);
        }

        return $conversation;
    }

    /**
     * Start a new conversation (deactivates the current one)
     */
    public function startNew(): self
    {
        $this->update(['is_active' => false]);

        return self::create([
            'user_id' => $this->user_id,
            'is_active' => true,
        ]);
    }
}
