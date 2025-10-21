<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Services\GamificationService;

class StatisticsController extends Controller
{
    public function index(GamificationService $gamificationService)
    {
        $user = Auth::user();
        $stats = $gamificationService->getUserStats($user);

        // Get category stats
        $categories = Question::distinct('categoria')->pluck('categoria');
        $categoryStats = [];

        foreach ($categories as $category) {
            $categoryStats[] = $gamificationService->getCategoryStats($user, $category);
        }

        return view('statistics', [
            'user' => $user,
            'stats' => $stats,
            'categoryStats' => $categoryStats,
        ]);
    }
}
