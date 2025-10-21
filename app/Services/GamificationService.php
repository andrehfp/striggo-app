<?php

namespace App\Services;

use App\Models\User;
use App\Models\Question;
use App\Models\UserAnswer;
use App\Models\Badge;

class GamificationService
{
    const XP_CORRECT = 10;
    const XP_INCORRECT = 3;

    /**
     * Process user answer and update progress
     */
    public function processAnswer(User $user, Question $question, string $answer): array
    {
        $correct = $answer === $question->resposta_correta;
        $xpEarned = $correct ? self::XP_CORRECT : self::XP_INCORRECT;

        // Record the answer
        UserAnswer::recordAnswer(
            $user->id,
            $question->id,
            $answer,
            $correct,
            $xpEarned
        );

        // Update user progress
        $progress = $user->getOrCreateProgress();
        $progress->addXP($xpEarned);
        $progress->updateStreak();
        $progress->total_questions_answered++;
        if ($correct) {
            $progress->correct_answers++;
        }
        $progress->questions_today++;
        $progress->save();

        // Check and unlock badges
        $this->checkBadges($user, $progress);

        return [
            'correct' => $correct,
            'xp_earned' => $xpEarned,
            'new_level' => $progress->level,
            'total_xp' => $progress->xp,
        ];
    }

    /**
     * Check and unlock badges for user
     */
    private function checkBadges(User $user, $progress): void
    {
        $badges = [
            'first_question' => fn() => $progress->total_questions_answered === 1,
            'ten_correct' => fn() => $progress->correct_answers === 10,
            'fifty_correct' => fn() => $progress->correct_answers === 50,
            'streak_7' => fn() => $progress->streak_days === 7,
            'streak_30' => fn() => $progress->streak_days === 30,
            'level_5' => fn() => $progress->level >= 5,
            'level_10' => fn() => $progress->level >= 10,
            'accuracy_90' => fn() => $progress->getAccuracyPercentage() >= 90,
            'hundred_questions' => fn() => $progress->total_questions_answered === 100,
            'perfection' => fn() => $this->hasStreak($user, 10),
        ];

        foreach ($badges as $badgeKey => $condition) {
            if ($condition()) {
                Badge::unlockForUser($user, $badgeKey);
            }
        }
    }

    /**
     * Check if user has a streak of correct answers
     */
    private function hasStreak(User $user, int $count): bool
    {
        $recentAnswers = $user->answers()
            ->latest()
            ->take($count)
            ->get();

        if ($recentAnswers->count() < $count) {
            return false;
        }

        return $recentAnswers->every(fn($answer) => $answer->correct);
    }

    /**
     * Get user daily progress
     */
    public function getDailyProgress(User $user): array
    {
        $progress = $user->getOrCreateProgress();

        return [
            'questions_today' => $progress->questions_today,
            'daily_goal' => $progress->daily_goal,
            'progress_percentage' => min(100, ($progress->questions_today / $progress->daily_goal) * 100),
            'goal_completed' => $progress->questions_today >= $progress->daily_goal,
        ];
    }

    /**
     * Get comprehensive user stats
     */
    public function getUserStats(User $user): array
    {
        $progress = $user->getOrCreateProgress();

        return [
            'level' => $progress->level,
            'xp' => $progress->xp,
            'xp_until_next_level' => $progress->getXpUntilNextLevel(),
            'progress_to_next_level' => $progress->getProgressToNextLevel(),
            'streak_days' => $progress->streak_days,
            'total_questions' => $progress->total_questions_answered,
            'correct_answers' => $progress->correct_answers,
            'accuracy' => round($progress->getAccuracyPercentage(), 2),
            'badges_count' => $user->badges()->count(),
        ];
    }

    /**
     * Get user answers for a specific category
     */
    public function getCategoryStats(User $user, string $category): array
    {
        $totalQuestions = Question::where('categoria', $category)->count();
        $answeredQuestions = $user->answers()
            ->whereHas('question', fn($q) => $q->where('categoria', $category))
            ->count();
        $correctAnswers = $user->answers()
            ->where('correct', true)
            ->whereHas('question', fn($q) => $q->where('categoria', $category))
            ->count();

        return [
            'category' => $category,
            'total_questions' => $totalQuestions,
            'answered_questions' => $answeredQuestions,
            'correct_answers' => $correctAnswers,
            'accuracy' => $answeredQuestions > 0
                ? round(($correctAnswers / $answeredQuestions) * 100, 2)
                : 0,
        ];
    }
}
