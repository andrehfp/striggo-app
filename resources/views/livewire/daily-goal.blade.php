<div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
    <div class="flex items-center justify-between mb-4">
        <div>
            <p class="text-sm text-gray-500 mb-1">Meta Diária</p>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-bold {{ $goalCompleted ? 'text-emerald-600' : 'text-gray-900' }}">
                    {{ $questionsToday }}
                </p>
                <p class="text-lg text-gray-400">/ {{ $dailyGoal }}</p>
            </div>
        </div>
        <div class="w-16 h-16 {{ $goalCompleted ? 'bg-gradient-to-br from-emerald-100 to-emerald-200' : 'bg-gradient-to-br from-gray-100 to-gray-200' }} rounded-2xl flex items-center justify-center">
            @if($goalCompleted)
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            @else
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @endif
        </div>
    </div>

    <div class="space-y-2">
        <div class="relative w-full bg-gray-200 rounded-full h-3 overflow-hidden">
            <div
                class="absolute inset-y-0 left-0 {{ $goalCompleted ? 'bg-gradient-to-r from-emerald-500 to-emerald-600' : 'bg-gradient-to-r from-primary-500 to-primary-600' }} rounded-full transition-all duration-500"
                style="width: {{ min(100, $progressPercentage) }}%"
            ></div>
        </div>
        @if($goalCompleted)
            <p class="text-sm text-emerald-600 font-medium">🎉 Meta concluída!</p>
        @else
            <p class="text-xs text-gray-500">{{ $dailyGoal - $questionsToday }} {{ ($dailyGoal - $questionsToday) === 1 ? 'questão restante' : 'questões restantes' }}</p>
        @endif
    </div>
</div>
