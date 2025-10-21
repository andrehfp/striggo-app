<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <!-- Total Questions -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-center">
            <div class="text-3xl mb-2">📊</div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_questions'] ?? 0 }}</p>
            <p class="text-xs text-gray-500">Questões Respondidas</p>
        </div>
    </div>

    <!-- Correct Answers -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-center">
            <div class="text-3xl mb-2">✅</div>
            <p class="text-2xl font-bold text-green-600">{{ $stats['correct_answers'] ?? 0 }}</p>
            <p class="text-xs text-gray-500">Acertos</p>
        </div>
    </div>

    <!-- Accuracy -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-center">
            <div class="text-3xl mb-2">🎯</div>
            <p class="text-2xl font-bold text-indigo-600">{{ $stats['accuracy'] ?? 0 }}%</p>
            <p class="text-xs text-gray-500">Taxa de Acerto</p>
        </div>
    </div>

    <!-- Badges -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-center">
            <div class="text-3xl mb-2">🏆</div>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['badges_count'] ?? 0 }}</p>
            <p class="text-xs text-gray-500">Conquistas</p>
        </div>
    </div>
</div>
