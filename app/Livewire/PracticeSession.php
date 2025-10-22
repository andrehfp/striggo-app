<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Question;
use App\Services\GamificationService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PracticeSession extends Component
{
    public int $totalQuestions = 10;
    public int $currentQuestionIndex = 0;
    public array $questionIds = [];
    public array $sessionAnswers = [];
    public ?string $startTime = null;
    public ?string $endTime = null;
    public bool $sessionComplete = false;

    // Stats tracked during session
    public int $totalXpEarned = 0;
    public int $correctCount = 0;

    protected GamificationService $gamificationService;

    public function boot(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    public function mount(int $questionCount = 10)
    {
        $this->totalQuestions = $questionCount;
        $this->startSession();
    }

    public function startSession()
    {
        $user = Auth::user();

        // Generate question list for this session using adaptive algorithm
        $this->questionIds = [];
        $usedIds = [];

        for ($i = 0; $i < $this->totalQuestions; $i++) {
            $question = $this->gamificationService->getAdaptiveQuestion($user);

            // Avoid duplicates in the same session
            $attempts = 0;
            while ($question && in_array($question->id, $usedIds) && $attempts < 10) {
                $question = Question::whereNotIn('id', $usedIds)
                    ->inRandomOrder()
                    ->first();
                $attempts++;
            }

            if ($question) {
                $this->questionIds[] = $question->id;
                $usedIds[] = $question->id;
            }
        }

        $this->currentQuestionIndex = 0;
        $this->sessionAnswers = [];
        $this->startTime = now()->toISOString();
        $this->endTime = null;
        $this->sessionComplete = false;
        $this->totalXpEarned = 0;
        $this->correctCount = 0;
    }

    public function getCurrentQuestion(): ?Question
    {
        if ($this->currentQuestionIndex >= count($this->questionIds)) {
            return null;
        }

        return Question::find($this->questionIds[$this->currentQuestionIndex]);
    }

    #[On('session-answer-submitted')]
    public function handleAnswerSubmitted($result)
    {
        // Store the answer result
        $this->sessionAnswers[] = [
            'question_id' => $this->questionIds[$this->currentQuestionIndex],
            'correct' => $result['correct'],
            'xp_earned' => $result['xp_earned'],
            'selected_answer' => $result['selected_answer'] ?? null,
        ];

        // Update session stats
        $this->totalXpEarned += $result['xp_earned'];
        if ($result['correct']) {
            $this->correctCount++;
        }
    }

    #[On('session-next-question')]
    public function nextQuestion()
    {
        \Log::info('PracticeSession::nextQuestion called', [
            'component_id' => $this->getId(),
            'currentIndex' => $this->currentQuestionIndex,
            'totalQuestions' => $this->totalQuestions,
            'backtrace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5),
        ]);

        $this->currentQuestionIndex++;

        \Log::info('After increment', [
            'newIndex' => $this->currentQuestionIndex,
        ]);

        // Check if session is complete
        if ($this->currentQuestionIndex >= $this->totalQuestions) {
            \Log::info('Session complete, calling completeSession()');
            $this->completeSession();
        }

        // Dispatch event to update progress bars
        $this->dispatch('session-progress-updated');
    }

    public function completeSession()
    {
        $this->sessionComplete = true;
        $this->endTime = now()->toISOString();
    }

    #[On('restart-session')]
    public function restartSession()
    {
        $this->startSession();
    }

    public function getSessionDuration(): string
    {
        if (!$this->startTime || !$this->endTime) {
            return '0:00';
        }

        $start = Carbon::parse($this->startTime);
        $end = Carbon::parse($this->endTime);
        $diff = $start->diffInSeconds($end);

        $minutes = floor($diff / 60);
        $seconds = $diff % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public function render()
    {
        return view('livewire.practice-session', [
            'currentQuestion' => $this->getCurrentQuestion(),
            'progress' => [
                'current' => $this->currentQuestionIndex + 1,
                'total' => $this->totalQuestions,
                'percentage' => ($this->currentQuestionIndex / $this->totalQuestions) * 100,
            ],
        ]);
    }
}
