<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Meta Diária</h3>

    <div class="flex items-center justify-between">
        <!-- Circular Progress -->
        <div class="relative inline-flex items-center justify-center">
            <svg class="w-32 h-32 transform -rotate-90">
                <!-- Background circle -->
                <circle
                    cx="64"
                    cy="64"
                    r="56"
                    stroke="currentColor"
                    stroke-width="8"
                    fill="none"
                    class="text-gray-200"
                />
                <!-- Progress circle -->
                <circle
                    cx="64"
                    cy="64"
                    r="56"
                    stroke="currentColor"
                    stroke-width="8"
                    fill="none"
                    stroke-linecap="round"
                    class="{{ $goalCompleted ? 'text-green-500' : 'text-indigo-600' }}"
                    style="stroke-dasharray: {{ 2 * 3.14159 * 56 }}; stroke-dashoffset: {{ 2 * 3.14159 * 56 * (1 - ($progressPercentage / 100)) }}; transition: stroke-dashoffset 0.5s ease;"
                />
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-3xl font-bold {{ $goalCompleted ? 'text-green-600' : 'text-gray-900' }}">
                    {{ $questionsToday }}
                </span>
                <span class="text-sm text-gray-500">de {{ $dailyGoal }}</span>
            </div>
        </div>

        <!-- Stats -->
        <div class="flex-1 ml-6">
            @if($goalCompleted)
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <span class="text-3xl mr-3">🎉</span>
                        <div>
                            <p class="font-semibold text-green-800">Meta Atingida!</p>
                            <p class="text-sm text-green-600">Parabéns pela dedicação!</p>
                        </div>
                    </div>
                </div>
            @else
                <div>
                    <p class="text-2xl font-bold text-gray-900 mb-1">
                        {{ $dailyGoal - $questionsToday }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $dailyGoal - $questionsToday === 1 ? 'questão restante' : 'questões restantes' }}
                    </p>
                    <div class="mt-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div
                                class="bg-indigo-600 h-2 rounded-full transition-all duration-500"
                                style="width: {{ min(100, $progressPercentage) }}%"
                            ></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ number_format($progressPercentage, 0) }}% completo</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
