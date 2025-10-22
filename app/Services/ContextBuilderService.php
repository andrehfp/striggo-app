<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAnswer;

class ContextBuilderService
{
    public function __construct(
        private GamificationService $gamificationService
    ) {}

    /**
     * Build comprehensive context about the user for the AI tutor
     */
    public function buildUserContext(User $user): string
    {
        $progress = $user->getOrCreateProgress();
        $stats = $this->gamificationService->getUserStats($user);
        $weakCategories = $this->gamificationService->getWeakestCategories($user, 3);
        $recentAnswers = $this->getRecentAnswers($user, 10);

        $context = "CONTEXTO DO ALUNO:\n\n";

        // Basic stats
        $context .= "Nome: {$user->name}\n";
        $context .= "Nível: {$stats['level']}\n";
        $context .= "XP Total: {$stats['xp']}\n";
        $context .= "XP até próximo nível: {$stats['xp_until_next_level']}\n\n";

        // Performance
        $context .= "DESEMPENHO:\n";
        $context .= "Total de questões respondidas: {$stats['total_questions']}\n";
        $context .= "Acertos: {$stats['correct_answers']}\n";
        $context .= "Precisão geral: {$stats['accuracy']}%\n";
        $context .= "Sequência de dias: {$stats['streak_days']} dias\n";
        $context .= "Conquistas desbloqueadas: {$stats['badges_count']}\n\n";

        // Weak areas
        if (!empty($weakCategories)) {
            $context .= "ÁREAS FRACAS (precisam de mais atenção):\n";
            foreach ($weakCategories as $category) {
                $context .= "- {$category['category']}: {$category['accuracy']}% de acerto ({$category['correct_answers']}/{$category['answered_questions']} corretas)\n";
            }
            $context .= "\n";
        }

        // Recent performance
        if (!empty($recentAnswers)) {
            $context .= "ÚLTIMAS RESPOSTAS:\n";
            foreach ($recentAnswers as $answer) {
                $status = $answer['correct'] ? '✓ CORRETA' : '✗ ERRADA';
                $context .= "- {$status}: {$answer['question_category']} (respondida em {$answer['answered_at']})\n";
            }
        }

        return $context;
    }

    /**
     * Get recent answers with question details
     */
    private function getRecentAnswers(User $user, int $limit = 10): array
    {
        $answers = UserAnswer::where('user_id', $user->id)
            ->with('question')
            ->latest()
            ->take($limit)
            ->get();

        return $answers->map(function ($answer) {
            return [
                'question_id' => $answer->question_id,
                'question_category' => $answer->question->categoria ?? 'N/A',
                'correct' => $answer->correct,
                'xp_earned' => $answer->xp_earned,
                'answered_at' => $answer->created_at->diffForHumans(),
            ];
        })->toArray();
    }

    /**
     * Build context for a specific question the user just answered
     */
    public function buildQuestionContext(User $user, int $questionId): string
    {
        $answer = UserAnswer::where('user_id', $user->id)
            ->where('question_id', $questionId)
            ->with('question')
            ->latest()
            ->first();

        if (!$answer || !$answer->question) {
            return '';
        }

        $question = $answer->question;
        $context = "\n\nCONTEXTO DA ÚLTIMA QUESTÃO:\n";
        $context .= "Categoria: {$question->categoria}\n";
        $context .= "Questão: {$question->enunciado}\n";
        $context .= "Resposta correta: {$question->resposta_correta}\n";
        $context .= "Resposta do aluno: {$answer->resposta_escolhida}\n";
        $context .= "Resultado: " . ($answer->correct ? 'CORRETA' : 'INCORRETA') . "\n";

        if ($question->explicacao) {
            $context .= "Explicação oficial: {$question->explicacao}\n";
        }

        return $context;
    }
}
