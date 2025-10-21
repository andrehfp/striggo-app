<div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-5">
    <div class="flex items-center justify-between mb-3">
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Nível</p>
            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $level }}</p>
        </div>
        <div class="text-right">
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">XP Total</p>
            <p class="text-lg font-medium text-indigo-600 dark:text-indigo-400">
                {{ number_format($xp, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div>
        <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 mb-1.5">
            <span>Nível {{ $level + 1 }}</span>
            <span>{{ $xpUntilNextLevel }} XP</span>
        </div>
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
            <div
                class="bg-indigo-600 dark:bg-indigo-500 h-2 rounded-full transition-all"
                style="width: {{ $progressPercentage }}%"
            ></div>
        </div>
    </div>
</div>
