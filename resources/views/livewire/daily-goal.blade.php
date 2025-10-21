<div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-5">
    <div class="flex items-center justify-between mb-3">
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Meta Diária</p>
            <div class="flex items-baseline gap-2">
                <p class="text-2xl font-semibold {{ $goalCompleted ? 'text-green-600 dark:text-green-400' : 'text-gray-900 dark:text-gray-100' }}">
                    {{ $questionsToday }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">/ {{ $dailyGoal }}</p>
            </div>
        </div>
        @if($goalCompleted)
            <div class="text-2xl">✓</div>
        @endif
    </div>

    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
        <div
            class="{{ $goalCompleted ? 'bg-green-600 dark:bg-green-500' : 'bg-indigo-600 dark:bg-indigo-500' }} h-2 rounded-full transition-all"
            style="width: {{ min(100, $progressPercentage) }}%"
        ></div>
    </div>

    @if(!$goalCompleted)
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
            {{ $dailyGoal - $questionsToday }} {{ ($dailyGoal - $questionsToday) === 1 ? 'questão restante' : 'questões restantes' }}
        </p>
    @endif
</div>
