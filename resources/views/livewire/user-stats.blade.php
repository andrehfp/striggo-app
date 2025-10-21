<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <!-- Total Questions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-5">
        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Respondidas</p>
        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            {{ $stats['total_questions'] ?? 0 }}
        </p>
    </div>

    <!-- Correct Answers -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-5">
        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Acertos</p>
        <p class="text-2xl font-semibold text-green-600 dark:text-green-400">
            {{ $stats['correct_answers'] ?? 0 }}
        </p>
    </div>

    <!-- Accuracy -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-5">
        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Precisão</p>
        <p class="text-2xl font-semibold text-indigo-600 dark:text-indigo-400">
            {{ $stats['accuracy'] ?? 0 }}%
        </p>
    </div>

    <!-- Badges -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-5">
        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Conquistas</p>
        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            {{ $stats['badges_count'] ?? 0 }}
        </p>
    </div>
</div>
