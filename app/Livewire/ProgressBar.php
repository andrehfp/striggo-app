<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class ProgressBar extends Component
{
    public int $level = 1;
    public int $xp = 0;
    public int $xpUntilNextLevel = 100;
    public float $progressPercentage = 0;

    public function mount()
    {
        $this->loadProgress();
    }

    #[On('answer-submitted')]
    public function refreshProgress()
    {
        $this->loadProgress();
    }

    private function loadProgress()
    {
        $user = Auth::user();
        $progress = $user->getOrCreateProgress();

        $this->level = $progress->level;
        $this->xp = $progress->xp;
        $this->xpUntilNextLevel = $progress->getXpUntilNextLevel();
        $this->progressPercentage = $progress->getProgressToNextLevel();
    }

    public function render()
    {
        return view('livewire.progress-bar');
    }
}
