<div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-5">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Sequência</p>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $streakDays }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $streakDays === 1 ? 'dia' : 'dias' }}
                </p>
            </div>
        </div>
        @if($streakDays >= 7)
            <div class="text-3xl">🔥</div>
        @endif
    </div>

    @if($streakDays === 0)
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
            Responda uma questão para começar
        </p>
    @endif
</div>
