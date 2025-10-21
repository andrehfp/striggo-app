<div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
        Categorias para Melhorar
    </h3>

    @if(count($categories) > 0)
        <div class="space-y-3">
            @foreach($categories as $category)
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900 dark:text-gray-100 mb-1">
                            {{ $category['category'] }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $category['correct_answers'] }} / {{ $category['answered_questions'] }} corretas
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-semibold
                            @if($category['accuracy'] >= 70) text-green-600 dark:text-green-400
                            @elseif($category['accuracy'] >= 50) text-yellow-600 dark:text-yellow-400
                            @else text-red-600 dark:text-red-400
                            @endif
                        ">
                            {{ number_format($category['accuracy'], 0) }}%
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 pt-4">
            O sistema prioriza questões dessas categorias automaticamente
        </p>
    @else
        <p class="text-gray-600 dark:text-gray-400 text-center py-8">
            Responda pelo menos 3 questões de cada categoria para ver suas áreas de melhoria
        </p>
    @endif
</div>
