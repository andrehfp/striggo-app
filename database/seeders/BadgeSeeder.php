<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'key' => 'first_question',
                'name' => 'Primeira Resposta',
                'description' => 'Respondeu sua primeira questão',
                'icon' => '🎯',
            ],
            [
                'key' => 'ten_correct',
                'name' => '10 Acertos',
                'description' => 'Acertou 10 questões',
                'icon' => '🎉',
            ],
            [
                'key' => 'fifty_correct',
                'name' => '50 Acertos',
                'description' => 'Acertou 50 questões',
                'icon' => '⭐',
            ],
            [
                'key' => 'streak_7',
                'name' => 'Sete Dias Seguidos',
                'description' => 'Estudou 7 dias consecutivos',
                'icon' => '🔥',
            ],
            [
                'key' => 'streak_30',
                'name' => 'Mês de Dedicação',
                'description' => 'Estudou 30 dias consecutivos',
                'icon' => '👑',
            ],
            [
                'key' => 'level_5',
                'name' => 'Nível 5',
                'description' => 'Alcançou o nível 5',
                'icon' => '💪',
            ],
            [
                'key' => 'level_10',
                'name' => 'Nível 10',
                'description' => 'Alcançou o nível 10',
                'icon' => '🚀',
            ],
            [
                'key' => 'accuracy_90',
                'name' => '90% de Precisão',
                'description' => 'Mantém 90% de taxa de acerto',
                'icon' => '💯',
            ],
            [
                'key' => 'hundred_questions',
                'name' => 'Centena',
                'description' => 'Respondeu 100 questões',
                'icon' => '💯',
            ],
            [
                'key' => 'complete_category',
                'name' => 'Especialista em Categoria',
                'description' => 'Respondeu todas as questões de uma categoria',
                'icon' => '🎓',
            ],
            [
                'key' => 'simulated_test',
                'name' => 'Prova Simulada Completa',
                'description' => 'Completou um simulado de 50 questões',
                'icon' => '📝',
            ],
            [
                'key' => 'morning_person',
                'name' => 'Madrugador',
                'description' => 'Respondeu uma questão às 5 da manhã',
                'icon' => '🌅',
            ],
            [
                'key' => 'speed_demon',
                'name' => 'Raio Veloz',
                'description' => 'Respondeu 5 questões em menos de 2 minutos',
                'icon' => '⚡',
            ],
            [
                'key' => 'comeback',
                'name' => 'Retorno Triunfante',
                'description' => 'Voltou a estudar após 7 dias sem estudar',
                'icon' => '🔄',
            ],
            [
                'key' => 'perfection',
                'name' => 'Perfeição',
                'description' => 'Acertou 10 questões seguidas',
                'icon' => '💎',
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
