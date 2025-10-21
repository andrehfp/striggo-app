<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\GamificationService;
use Illuminate\Support\Facades\Auth;

class DailyGoal extends Component
{
    public int $questionsToday = 0;
    public int $dailyGoal = 10;
    public float $progressPercentage = 0;
    public bool $goalCompleted = false;

    protected GamificationService $gamificationService;

    public function boot(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    public function mount()
    {
        $this->loadDailyProgress();
    }

    #[On('answer-submitted')]
    public function refreshDailyGoal()
    {
        $this->loadDailyProgress();
    }

    private function loadDailyProgress()
    {
        $user = Auth::user();
        $dailyProgress = $this->gamificationService->getDailyProgress($user);

        $this->questionsToday = $dailyProgress['questions_today'];
        $this->dailyGoal = $dailyProgress['daily_goal'];
        $this->progressPercentage = $dailyProgress['progress_percentage'];
        $this->goalCompleted = $dailyProgress['goal_completed'];
    }

    public function render()
    {
        return view('livewire.daily-goal');
    }
}
