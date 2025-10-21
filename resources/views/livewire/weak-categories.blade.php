<div class="bg-white rounded-xl shadow-md p-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold text-gray-900">
            Categorias para Melhorar
        </h3>
        <div class="inline-flex items-center px-3 py-1 bg-blue-100 rounded-full text-blue-700 text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            Priorizadas automaticamente
        </div>
    </div>

    @if(count($categories) > 0)
        <div class="space-y-4">
            @foreach($categories as $category)
                <div class="flex items-center justify-between p-5 bg-gradient-to-r from-gray-50 to-white rounded-xl hover:shadow-md transition-shadow border border-gray-100">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 mb-2 text-lg">
                            {{ $category['category'] }}
                        </p>
                        <div class="flex items-center gap-4 text-sm">
                            <span class="text-gray-600">
                                {{ $category['correct_answers'] }} / {{ $category['answered_questions'] }} corretas
                            </span>
                            <div class="flex-1 max-w-xs">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div
                                        class="h-2 rounded-full transition-all
                                        @if($category['accuracy'] >= 70) bg-emerald-500
                                        @elseif($category['accuracy'] >= 50) bg-amber-500
                                        @else bg-red-500
                                        @endif"
                                        style="width: {{ $category['accuracy'] }}%"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right ml-6">
                        <p class="text-4xl font-bold
                            @if($category['accuracy'] >= 70) text-emerald-600
                            @elseif($category['accuracy'] >= 50) text-amber-600
                            @else text-red-600
                            @endif
                        ">
                            {{ number_format($category['accuracy'], 0) }}<span class="text-2xl">%</span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <p class="text-gray-600 text-lg">
                Responda pelo menos 3 questões de cada categoria
            </p>
            <p class="text-gray-500 text-sm mt-2">
                para ver suas áreas de melhoria
            </p>
        </div>
    @endif
</div>
