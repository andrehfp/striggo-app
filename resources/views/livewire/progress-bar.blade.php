<div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
    <div class="flex items-center justify-between mb-4">
        <div>
            <p class="text-sm text-gray-500 mb-1">Nível</p>
            <p class="text-3xl font-bold text-gray-900">{{ $level }}</p>
        </div>
        <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center">
            <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        </div>
    </div>

    <div class="space-y-2">
        <div class="flex justify-between text-sm">
            <span class="text-gray-600">{{ number_format($xp, 0, ',', '.') }} XP</span>
            <span class="text-gray-900 font-semibold">Nível {{ $level + 1 }}</span>
        </div>
        <div class="relative w-full bg-gray-200 rounded-full h-3 overflow-hidden">
            <div
                class="absolute inset-y-0 left-0 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full transition-all duration-500"
                style="width: {{ $progressPercentage }}%"
            ></div>
        </div>
        <p class="text-xs text-gray-500 text-right">{{ $xpUntilNextLevel }} XP até o próximo nível</p>
    </div>
</div>
