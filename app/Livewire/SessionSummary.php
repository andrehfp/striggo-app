<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class SessionSummary extends Component
{
    public int $totalQuestions;
    public int $correctCount;
    public int $totalXpEarned;
    public string $duration;
    public array $sessionAnswers;
    public array $questionIds;
    public ?int $expandedQuestionIndex = null;

    public function mount(
        int $totalQuestions,
        int $correctCount,
        int $totalXpEarned,
        string $duration,
        array $sessionAnswers,
        array $questionIds
    ) {
        $this->totalQuestions = $totalQuestions;
        $this->correctCount = $correctCount;
        $this->totalXpEarned = $totalXpEarned;
        $this->duration = $duration;
        $this->sessionAnswers = $sessionAnswers;
        $this->questionIds = $questionIds;
    }

    public function toggleQuestion(int $index)
    {
        if ($this->expandedQuestionIndex === $index) {
            $this->expandedQuestionIndex = null;
        } else {
            $this->expandedQuestionIndex = $index;
        }
    }

    public function getAccuracyPercentage(): int
    {
        if ($this->totalQuestions === 0) {
            return 0;
        }
        return round(($this->correctCount / $this->totalQuestions) * 100);
    }

    public function restartSession()
    {
        $this->dispatch('restart-session')->to('practice-session');
    }

    public function render()
    {
        $user = Auth::user();
        $progress = $user->getOrCreateProgress();

        // Load all questions for the session
        $questions = Question::whereIn('id', $this->questionIds)
            ->get()
            ->keyBy('id');

        // Combine questions with answers
        $reviewQuestions = [];
        foreach ($this->sessionAnswers as $index => $answer) {
            $question = $questions[$answer['question_id']] ?? null;
            if ($question) {
                $reviewQuestions[] = [
                    'index' => $index,
                    'question' => $question,
                    'correct' => $answer['correct'],
                    'xp_earned' => $answer['xp_earned'],
                    'selected_answer' => $answer['selected_answer'] ?? null,
                ];
            }
        }

        return view('livewire.session-summary', [
            'user_level' => $progress->level,
            'user_xp' => $progress->xp,
            'xp_to_next_level' => $progress->getXpUntilNextLevel(),
            'review_questions' => $reviewQuestions,
        ]);
    }
}
