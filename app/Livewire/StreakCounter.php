<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class StreakCounter extends Component
{
    public int $streakDays = 0;

    public function mount()
    {
        $this->loadStreak();
    }

    #[On('answer-submitted')]
    public function refreshStreak()
    {
        $this->loadStreak();
    }

    private function loadStreak()
    {
        $user = Auth::user();
        $progress = $user->getOrCreateProgress();

        $this->streakDays = $progress->streak_days;
    }

    public function render()
    {
        return view('livewire.streak-counter');
    }
}
