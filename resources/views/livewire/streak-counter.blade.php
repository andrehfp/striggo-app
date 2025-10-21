<div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
    <div class="flex items-center justify-between mb-4">
        <div>
            <p class="text-sm text-gray-500 mb-1">Sequência</p>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-bold {{ $streakDays >= 7 ? 'text-orange-600' : 'text-gray-900' }}">{{ $streakDays }}</p>
                <p class="text-lg text-gray-400">{{ $streakDays === 1 ? 'dia' : 'dias' }}</p>
            </div>
        </div>
        <div class="w-16 h-16 {{ $streakDays >= 7 ? 'bg-gradient-to-br from-orange-100 to-red-200' : 'bg-gradient-to-br from-gray-100 to-gray-200' }} rounded-2xl flex items-center justify-center text-3xl">
            @if($streakDays >= 7)
                🔥
            @else
                📅
            @endif
        </div>
    </div>

    @if($streakDays === 0)
        <p class="text-sm text-gray-500">
            Responda uma questão hoje para começar sua sequência
        </p>
    @elseif($streakDays >= 7)
        <p class="text-sm text-orange-600 font-medium">
            🎯 Você está em chamas!
        </p>
    @else
        <p class="text-sm text-gray-500">
            Continue estudando diariamente
        </p>
    @endif
</div>
