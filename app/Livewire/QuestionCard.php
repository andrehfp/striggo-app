<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Question;
use App\Services\GamificationService;
use Illuminate\Support\Facades\Auth;

class QuestionCard extends Component
{
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

    public function mount()
    {
        $this->loadNewQuestion();
    }

    public function loadNewQuestion()
    {
        $user = Auth::user();

        // Get a random question that user hasn't answered yet
        $this->question = Question::whereNotIn('id', function($query) use ($user) {
            $query->select('question_id')
                  ->from('user_answers')
                  ->where('user_id', $user->id);
        })->inRandomOrder()->first();

        // If all questions answered, get any random question
        if (!$this->question) {
            $this->question = Question::inRandomOrder()->first();
        }

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
    }

    public function nextQuestion()
    {
        $this->loadNewQuestion();
    }

    public function render()
    {
        return view('livewire.question-card');
    }
}
