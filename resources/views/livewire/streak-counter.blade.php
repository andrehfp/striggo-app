<div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-lg shadow p-6 text-white">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="text-5xl mr-4">🔥</div>
            <div>
                <p class="text-sm opacity-90">Sequência</p>
                <p class="text-4xl font-bold">{{ $streakDays }}</p>
                <p class="text-xs opacity-75">{{ $streakDays === 1 ? 'dia' : 'dias' }} seguidos</p>
            </div>
        </div>

        @if($streakDays >= 7)
            <div class="text-right">
                <span class="text-2xl">⭐</span>
                <p class="text-xs opacity-90 mt-1">Incrível!</p>
            </div>
        @endif
    </div>

    @if($streakDays === 0)
        <div class="mt-4 pt-4 border-t border-white border-opacity-20">
            <p class="text-sm opacity-90">💪 Responda uma questão para começar sua sequência!</p>
        </div>
    @elseif($streakDays >= 7)
        <div class="mt-4 pt-4 border-t border-white border-opacity-20">
            <p class="text-sm opacity-90">🎯 Continue assim! Sua dedicação é inspiradora!</p>
        </div>
    @endif
</div>
