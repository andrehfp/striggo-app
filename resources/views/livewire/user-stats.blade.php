<div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
    <!-- Total Questions -->
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-xl mb-3">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <p class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_questions'] ?? 0 }}</p>
        <p class="text-sm text-gray-500">Respondidas</p>
    </div>

    <!-- Correct Answers -->
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 rounded-xl mb-3">
            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-3xl font-bold text-emerald-600 mb-1">{{ $stats['correct_answers'] ?? 0 }}</p>
        <p class="text-sm text-gray-500">Acertos</p>
    </div>

    <!-- Accuracy -->
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-purple-100 rounded-xl mb-3">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <p class="text-3xl font-bold text-purple-600 mb-1">{{ $stats['accuracy'] ?? 0 }}%</p>
        <p class="text-sm text-gray-500">Precisão</p>
    </div>

    <!-- Badges -->
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-amber-100 rounded-xl mb-3">
            <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        </div>
        <p class="text-3xl font-bold text-amber-600 mb-1">{{ $stats['badges_count'] ?? 0 }}</p>
        <p class="text-sm text-gray-500">Conquistas</p>
    </div>
</div>
