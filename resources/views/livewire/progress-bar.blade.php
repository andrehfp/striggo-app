<div class="bg-white rounded-lg shadow p-6">
    <!-- Level Badge -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                {{ $level }}
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Nível</p>
                <p class="text-2xl font-bold text-gray-900">{{ $level }}</p>
            </div>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">XP Total</p>
            <p class="text-xl font-semibold text-indigo-600">{{ number_format($xp, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="mb-2">
        <div class="flex justify-between text-sm text-gray-600 mb-1">
            <span>Progresso para o Nível {{ $level + 1 }}</span>
            <span>{{ $xpUntilNextLevel }} XP restantes</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
            <div
                class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-500 ease-out"
                style="width: {{ $progressPercentage }}%"
            ></div>
        </div>
    </div>

    <!-- XP Info -->
    <p class="text-xs text-gray-500 text-center mt-2">
        {{ number_format($progressPercentage, 1) }}% completo
    </p>
</div>
