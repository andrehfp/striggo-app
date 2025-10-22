<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserProgress extends Model
{
    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'xp',
        'level',
        'streak_days',
        'last_study_date',
        'daily_goal',
        'questions_today',
        'total_questions_answered',
        'correct_answers',
    ];

    protected $casts = [
        'last_study_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addXP(int $xp): void
    {
        $this->xp += $xp;
        $this->checkLevelUp();
        $this->save();
    }

    public function checkLevelUp(): void
    {
        $xpPerLevel = 100;
        $newLevel = intval($this->xp / $xpPerLevel) + 1;

        if ($newLevel > $this->level) {
            $this->level = $newLevel;
        }
    }

    public function updateStreak(): void
    {
        $today = Carbon::today();

        if ($this->last_study_date?->isToday()) {
            // Already studied today
            return;
        }

        // Reset daily counter for a new day
        $this->questions_today = 0;

        if ($this->last_study_date?->isYesterday()) {
            // Continuing the streak
            $this->streak_days++;
        } else {
            // Broken streak or first time
            $this->streak_days = 1;
        }

        $this->last_study_date = $today;
        $this->save();
    }

    public function getAccuracyPercentage(): float
    {
        if ($this->total_questions_answered === 0) {
            return 0;
        }

        return ($this->correct_answers / $this->total_questions_answered) * 100;
    }

    public function getXpUntilNextLevel(): int
    {
        $xpPerLevel = 100;
        $xpForCurrentLevel = ($this->level - 1) * $xpPerLevel;
        $xpNeededForNextLevel = $this->level * $xpPerLevel;

        return $xpNeededForNextLevel - $this->xp;
    }

    public function getProgressToNextLevel(): float
    {
        $xpPerLevel = 100;
        $xpForCurrentLevel = ($this->level - 1) * $xpPerLevel;
        $currentProgress = $this->xp - $xpForCurrentLevel;

        return ($currentProgress / $xpPerLevel) * 100;
    }

    /**
     * Reset daily counter if it's a new day
     */
    public function resetDailyCounterIfNeeded(): void
    {
        if (!$this->last_study_date?->isToday()) {
            $this->questions_today = 0;
            $this->save();
        }
    }
}
