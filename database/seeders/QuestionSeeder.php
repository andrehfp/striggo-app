<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('questions.json'));
        $questions = json_decode($json, true);

        foreach ($questions as $q) {
            Question::create([
                'numero' => $q['numero'],
                'enunciado' => $q['enunciado'],
                'opcao_a' => $q['opcao_a'],
                'opcao_b' => $q['opcao_b'],
                'opcao_c' => $q['opcao_c'],
                'opcao_d' => $q['opcao_d'],
                'resposta_correta' => $q['resposta_correta'],
                'categoria' => $q['categoria'],
                'prova_tipo' => 'tipo_1',
            ]);
        }
    }
}
