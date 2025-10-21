<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\GamificationService;
use Illuminate\Support\Facades\Auth;

class WeakCategories extends Component
{
    public array $categories = [];

    protected GamificationService $gamificationService;

    public function boot(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    public function mount()
    {
        $user = Auth::user();
        $this->categories = $this->gamificationService->getWeakestCategories($user, 5);
    }

    public function render()
    {
        return view('livewire.weak-categories');
    }
}
