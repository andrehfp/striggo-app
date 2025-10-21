<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'resposta_escolhida',
        'correct',
        'xp_earned',
        'next_review_at',
        'repetition_number',
        'easiness_factor',
        'interval_days',
    ];

    protected $casts = [
        'correct' => 'boolean',
        'next_review_at' => 'datetime',
        'easiness_factor' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public static function recordAnswer(
        int $userId,
        int $questionId,
        string $answer,
        bool $correct,
        int $xpEarned
    ): self {
        return self::create([
            'user_id' => $userId,
            'question_id' => $questionId,
            'resposta_escolhida' => $answer,
            'correct' => $correct,
            'xp_earned' => $xpEarned,
        ]);
    }
}
