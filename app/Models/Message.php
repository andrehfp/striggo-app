<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'role',
        'content',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Create a user message
     */
    public static function createUserMessage(Conversation $conversation, string $content): self
    {
        return self::create([
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'content' => $content,
        ]);
    }

    /**
     * Create an assistant message
     */
    public static function createAssistantMessage(Conversation $conversation, string $content, ?array $metadata = null): self
    {
        return self::create([
            'conversation_id' => $conversation->id,
            'role' => 'assistant',
            'content' => $content,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Create a system message
     */
    public static function createSystemMessage(Conversation $conversation, string $content): self
    {
        return self::create([
            'conversation_id' => $conversation->id,
            'role' => 'system',
            'content' => $content,
        ]);
    }
}
