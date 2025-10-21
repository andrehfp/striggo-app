<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Áreas para Melhorar</h3>

    @if(count($categories) > 0)
        <div class="space-y-3">
            @foreach($categories as $category)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">{{ $category['category'] }}</p>
                        <p class="text-sm text-gray-600">
                            {{ $category['correct_answers'] }}/{{ $category['answered_questions'] }} corretas
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-2xl font-bold
                                @if($category['accuracy'] >= 70) text-green-600
                                @elseif($category['accuracy'] >= 50) text-yellow-600
                                @else text-red-600
                                @endif
                            ">
                                {{ number_format($category['accuracy'], 0) }}%
                            </p>
                            <p class="text-xs text-gray-500">acurácia</p>
                        </div>
                        <div class="w-16 h-16">
                            <svg class="transform -rotate-90" width="64" height="64">
                                <circle
                                    cx="32"
                                    cy="32"
                                    r="28"
                                    stroke="#e5e7eb"
                                    stroke-width="6"
                                    fill="none"
                                />
                                <circle
                                    cx="32"
                                    cy="32"
                                    r="28"
                                    stroke="@if($category['accuracy'] >= 70) #10b981 @elseif($category['accuracy'] >= 50) #f59e0b @else #ef4444 @endif"
                                    stroke-width="6"
                                    fill="none"
                                    stroke-dasharray="{{ 2 * 3.14159 * 28 }}"
                                    stroke-dashoffset="{{ 2 * 3.14159 * 28 * (1 - $category['accuracy'] / 100) }}"
                                    stroke-linecap="round"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <p class="mt-4 text-sm text-gray-600">
            💡 O sistema vai priorizar questões dessas categorias para você praticar!
        </p>
    @else
        <p class="text-gray-600 text-center py-4">
            Responda pelo menos 3 questões de cada categoria para ver suas áreas de melhoria.
        </p>
    @endif
</div>
