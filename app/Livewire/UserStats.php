<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\GamificationService;
use Illuminate\Support\Facades\Auth;

class UserStats extends Component
{
    public array $stats = [];

    protected GamificationService $gamificationService;

    public function boot(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    public function mount()
    {
        $this->loadStats();
    }

    #[On('answer-submitted')]
    public function refreshStats()
    {
        $this->loadStats();
    }

    private function loadStats()
    {
        $user = Auth::user();
        $this->stats = $this->gamificationService->getUserStats($user);
    }

    public function render()
    {
        return view('livewire.user-stats');
    }
}
