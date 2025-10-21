<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Question;
use App\Services\GamificationService;
use Illuminate\Support\Facades\Auth;

class QuestionCard extends Component
{
    public ?int $questionId = null;
    public bool $isSessionMode = false;
    public ?Question $question = null;
    public ?string $selectedAnswer = null;
    public bool $answered = false;
    public bool $wasCorrect = false;
    public int $xpEarned = 0;
    public $shuffledOptions = ['A', 'B', 'C', 'D'];

    protected GamificationService $gamificationService;

    public function boot(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    public function mount(?int $questionId = null, bool $isSessionMode = false)
    {
        $this->questionId = $questionId;
        $this->isSessionMode = $isSessionMode;

        if ($questionId) {
            // Session mode: load specific question
            $this->question = Question::find($questionId);
        } else {
            // Standalone mode: load adaptive question
            $this->loadNewQuestion();
        }

        $this->shuffleOptions();
    }

    public function loadNewQuestion()
    {
        $user = Auth::user();

        // Use adaptive algorithm to get next question
        $this->question = $this->gamificationService->getAdaptiveQuestion($user);

        // Shuffle answer options to prevent memorization by letter
        $this->shuffleOptions();

        // Reset state after loading new question
        $this->selectedAnswer = null;
        $this->answered = false;
        $this->wasCorrect = false;
        $this->xpEarned = 0;
    }

    private function shuffleOptions()
    {
        $options = ['A', 'B', 'C', 'D'];
        shuffle($options);
        $this->shuffledOptions = $options;
    }

    public function selectAnswer(string $answer)
    {
        if ($this->answered) {
            return;
        }

        $this->selectedAnswer = $answer;
    }

    public function submitAnswer()
    {
        if (!$this->selectedAnswer || $this->answered) {
            return;
        }

        $user = Auth::user();

        $result = $this->gamificationService->processAnswer(
            $user,
            $this->question,
            $this->selectedAnswer
        );

        $this->answered = true;
        $this->wasCorrect = $result['correct'];
        $this->xpEarned = $result['xp_earned'];

        // Dispatch event to update other components
        $this->dispatch('answer-submitted', [
            'correct' => $this->wasCorrect,
            'xp' => $this->xpEarned,
            'newLevel' => $result['new_level'],
        ]);

        // If in session mode, notify parent component
        if ($this->isSessionMode) {
            $this->dispatch('session-answer-submitted', [
                'correct' => $this->wasCorrect,
                'xp_earned' => $this->xpEarned,
                'selected_answer' => $this->selectedAnswer,
            ])->to('practice-session');
        }
    }

    public function nextQuestion()
    {
        if ($this->isSessionMode) {
            // In session mode, notify parent to move to next question
            $this->dispatch('session-next-question')->to('practice-session');
        } else {
            // Standalone mode: load next question directly
            $this->loadNewQuestion();
        }
    }

    public function render()
    {
        return view('livewire.question-card');
    }
}
