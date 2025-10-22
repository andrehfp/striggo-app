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

        // Check if this is a re-answer (review)
        $existingAnswer = UserAnswer::where('user_id', $user->id)
            ->where('question_id', $question->id)
            ->first();

        if ($existingAnswer) {
            // Update existing answer for spaced repetition
            $existingAnswer->update([
                'resposta_escolhida' => $answer,
                'correct' => $correct,
                'xp_earned' => $xpEarned,
            ]);
            $this->updateSpacedRepetition($existingAnswer, $correct);
            $userAnswer = $existingAnswer;
        } else {
            // Record new answer
            $userAnswer = UserAnswer::recordAnswer(
                $user->id,
                $question->id,
                $answer,
                $correct,
                $xpEarned
            );
            // Set initial SRS values
            $this->updateSpacedRepetition($userAnswer, $correct);
        }

        // Update user progress
        $progress = $user->getOrCreateProgress();
        $progress->addXP($xpEarned);
        $progress->updateStreak();

        if (!$existingAnswer) {
            $progress->total_questions_answered++;
        }

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

        // Ensure daily counter is reset if it's a new day
        $progress->resetDailyCounterIfNeeded();

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

    /**
     * Get all category stats for user, ordered by accuracy (worst first)
     */
    public function getAllCategoriesStats(User $user): array
    {
        $categories = Question::distinct('categoria')->pluck('categoria');
        $stats = [];

        foreach ($categories as $category) {
            $stats[] = $this->getCategoryStats($user, $category);
        }

        // Sort by accuracy (lowest first) - these are the weak categories
        usort($stats, fn($a, $b) => $a['accuracy'] <=> $b['accuracy']);

        return $stats;
    }

    /**
     * Get weakest categories for adaptive learning
     */
    public function getWeakestCategories(User $user, int $limit = 3): array
    {
        $stats = $this->getAllCategoriesStats($user);

        // Filter categories where user has answered at least 3 questions
        $stats = array_filter($stats, fn($s) => $s['answered_questions'] >= 3);

        return array_slice($stats, 0, $limit);
    }

    /**
     * Get next question using adaptive algorithm
     * Prioritizes: 1) Questions due for review, 2) Weak categories, 3) Unanswered questions
     */
    public function getAdaptiveQuestion(User $user): ?Question
    {
        // 1. First, check for questions due for review (Spaced Repetition)
        $dueForReview = $this->getQuestionDueForReview($user);
        if ($dueForReview) {
            return $dueForReview;
        }

        // 2. Get weakest categories
        $weakCategories = $this->getWeakestCategories($user);
        $weakCategoryNames = array_column($weakCategories, 'category');

        // 3. Try to get unanswered question from weak categories (70% chance)
        if (!empty($weakCategoryNames) && rand(1, 100) <= 70) {
            $question = Question::whereIn('categoria', $weakCategoryNames)
                ->whereNotIn('id', function($query) use ($user) {
                    $query->select('question_id')
                          ->from('user_answers')
                          ->where('user_id', $user->id);
                })
                ->inRandomOrder()
                ->first();

            if ($question) {
                return $question;
            }
        }

        // 4. Get any unanswered question
        $question = Question::whereNotIn('id', function($query) use ($user) {
            $query->select('question_id')
                  ->from('user_answers')
                  ->where('user_id', $user->id);
        })->inRandomOrder()->first();

        // 5. If all questions answered, get random question from weak categories
        if (!$question && !empty($weakCategoryNames)) {
            $question = Question::whereIn('categoria', $weakCategoryNames)
                ->inRandomOrder()
                ->first();
        }

        // 6. Last resort: any random question
        return $question ?? Question::inRandomOrder()->first();
    }

    /**
     * Get question that is due for review (Spaced Repetition)
     */
    private function getQuestionDueForReview(User $user): ?Question
    {
        $dueAnswer = UserAnswer::where('user_id', $user->id)
            ->where('next_review_at', '<=', now())
            ->whereNotNull('next_review_at')
            ->orderBy('next_review_at', 'asc')
            ->first();

        return $dueAnswer ? $dueAnswer->question : null;
    }

    /**
     * Update Spaced Repetition data using SM-2 algorithm
     */
    public function updateSpacedRepetition(UserAnswer $answer, bool $wasCorrect): void
    {
        // SM-2 Algorithm implementation
        $quality = $wasCorrect ? 4 : 2; // 4 = correct, 2 = incorrect (simplified)

        // Calculate new easiness factor
        $ef = $answer->easiness_factor;
        $newEF = $ef + (0.1 - (5 - $quality) * (0.08 + (5 - $quality) * 0.02));
        $newEF = max(1.3, $newEF); // Minimum EF is 1.3

        // Calculate new interval
        if (!$wasCorrect) {
            // If incorrect, reset and review soon
            $repetition = 0;
            $interval = 1; // Review tomorrow
        } else {
            $repetition = $answer->repetition_number + 1;

            if ($repetition == 1) {
                $interval = 1;
            } elseif ($repetition == 2) {
                $interval = 6;
            } else {
                $interval = round($answer->interval_days * $newEF);
            }
        }

        // Update the answer record
        $answer->update([
            'easiness_factor' => $newEF,
            'repetition_number' => $repetition,
            'interval_days' => $interval,
            'next_review_at' => now()->addDays($interval),
        ]);
    }
}
