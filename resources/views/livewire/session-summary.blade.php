<div class="max-w-5xl mx-auto px-4">
    <!-- Celebration Header -->
    <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12 mb-8 text-center">
        <div class="text-6xl sm:text-7xl mb-6">
            @if($this->getAccuracyPercentage() >= 80)
                🎉
            @elseif($this->getAccuracyPercentage() >= 60)
                👍
            @else
                💪
            @endif
        </div>

        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3">
            @if($this->getAccuracyPercentage() >= 80)
                Excelente trabalho!
            @elseif($this->getAccuracyPercentage() >= 60)
                Bom trabalho!
            @else
                Continue praticando!
            @endif
        </h1>

        <p class="text-lg text-gray-600 mb-8">
            Você completou sua sessão de prática
        </p>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <!-- Score -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-6">
                <div class="text-3xl font-bold text-green-700 mb-1">
                    {{ $correctCount }}/{{ $totalQuestions }}
                </div>
                <div class="text-sm text-green-600 font-medium">Acertos</div>
            </div>

            <!-- Accuracy -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-6">
                <div class="text-3xl font-bold text-blue-700 mb-1">
                    {{ $this->getAccuracyPercentage() }}%
                </div>
                <div class="text-sm text-blue-600 font-medium">Precisão</div>
            </div>

            <!-- XP Earned -->
            <div class="bg-gradient-to-br from-purple-50 to-violet-50 border-2 border-purple-200 rounded-xl p-6">
                <div class="text-3xl font-bold text-purple-700 mb-1">
                    +{{ $totalXpEarned }}
                </div>
                <div class="text-sm text-purple-600 font-medium">XP</div>
            </div>

            <!-- Time -->
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 border-2 border-orange-200 rounded-xl p-6">
                <div class="text-3xl font-bold text-orange-700 mb-1">
                    {{ $duration }}
                </div>
                <div class="text-sm text-orange-600 font-medium">Tempo</div>
            </div>
        </div>

        <!-- Level Progress -->
        <div class="bg-gradient-to-r from-primary-50 to-indigo-50 border-2 border-primary-200 rounded-xl p-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-primary-900">
                    Nível {{ $user_level }}
                </span>
                <span class="text-sm font-semibold text-primary-700">
                    {{ $user_xp }} XP
                </span>
            </div>
            <div class="w-full bg-white rounded-full h-4 overflow-hidden shadow-inner">
                <div
                    class="bg-gradient-to-r from-primary-500 to-indigo-500 h-4 rounded-full transition-all duration-500"
                    style="width: {{ min(100, ($user_xp / ($user_xp + $xp_to_next_level)) * 100) }}%"
                ></div>
            </div>
            <div class="mt-2 text-xs text-primary-600 text-center">
                Faltam {{ $xp_to_next_level }} XP para o próximo nível
            </div>
        </div>
    </div>

    <!-- Question Review Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Revisão das Questões
        </h2>

        <div class="space-y-3">
            @foreach($review_questions as $item)
                <div class="border-2 rounded-xl overflow-hidden transition-all duration-200
                    {{ $item['correct'] ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">

                    <!-- Question Header (clickable) -->
                    <button
                        wire:click="toggleQuestion({{ $item['index'] }})"
                        class="w-full px-6 py-4 flex items-center justify-between hover:bg-white/50 transition-colors"
                    >
                        <div class="flex items-center flex-1 text-left">
                            <!-- Icon -->
                            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center mr-4
                                {{ $item['correct'] ? 'bg-green-500' : 'bg-red-500' }}">
                                @if($item['correct'])
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                @endif
                            </div>

                            <!-- Question Info -->
                            <div class="flex-1">
                                <div class="font-semibold {{ $item['correct'] ? 'text-green-900' : 'text-red-900' }}">
                                    Questão #{{ $item['question']->numero }}
                                </div>
                                <div class="text-sm {{ $item['correct'] ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $item['question']->categoria }} • {{ $item['xp_earned'] }} XP
                                </div>
                            </div>

                            <!-- Expand Icon -->
                            <svg
                                class="w-5 h-5 {{ $item['correct'] ? 'text-green-600' : 'text-red-600' }} transition-transform duration-200 {{ $expandedQuestionIndex === $item['index'] ? 'rotate-180' : '' }}"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>

                    <!-- Question Details (expandable) -->
                    @if($expandedQuestionIndex === $item['index'])
                        <div class="px-6 pb-6 border-t-2 {{ $item['correct'] ? 'border-green-200 bg-white' : 'border-red-200 bg-white' }}">
                            <!-- Question Text -->
                            <div class="mt-4 mb-4">
                                <p class="text-gray-900 leading-relaxed whitespace-pre-line">
                                    {{ $item['question']->enunciado }}
                                </p>
                            </div>

                            <!-- Options -->
                            <div class="space-y-2 mb-4">
                                @foreach(['A', 'B', 'C', 'D'] as $option)
                                    <div class="flex items-start p-3 rounded-lg
                                        @if($option === $item['question']->resposta_correta)
                                            bg-green-100 border-2 border-green-300
                                        @elseif($option === $item['selected_answer'] && !$item['correct'])
                                            bg-red-100 border-2 border-red-300
                                        @else
                                            bg-gray-50 border-2 border-gray-200
                                        @endif
                                    ">
                                        <span class="font-bold mr-3 {{ $option === $item['question']->resposta_correta ? 'text-green-700' : ($option === $item['selected_answer'] && !$item['correct'] ? 'text-red-700' : 'text-gray-600') }}">
                                            {{ $option }}.
                                        </span>
                                        <span class="flex-1 {{ $option === $item['question']->resposta_correta ? 'text-green-900' : ($option === $item['selected_answer'] && !$item['correct'] ? 'text-red-900' : 'text-gray-700') }}">
                                            {{ $item['question']->{'opcao_' . strtolower($option)} }}
                                        </span>
                                        @if($option === $item['question']->resposta_correta)
                                            <svg class="w-5 h-5 text-green-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- Explanation -->
                            @if($item['question']->explicacao)
                                <div class="mt-4 p-4 {{ $item['correct'] ? 'bg-green-50 border-l-4 border-green-500' : 'bg-red-50 border-l-4 border-red-500' }} rounded">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 {{ $item['correct'] ? 'text-green-600' : 'text-red-600' }} mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold {{ $item['correct'] ? 'text-green-900' : 'text-red-900' }} mb-1">
                                                Explicação
                                            </p>
                                            <p class="text-sm {{ $item['correct'] ? 'text-green-800' : 'text-red-800' }} leading-relaxed">
                                                {{ $item['question']->explicacao }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 mb-8">
        <button
            wire:click="restartSession"
            class="flex-1 px-8 py-4 bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Praticar Novamente
        </button>

        <a
            href="{{ route('dashboard') }}"
            class="flex-1 px-8 py-4 bg-white hover:bg-gray-50 text-gray-700 border-2 border-gray-300 rounded-xl font-semibold shadow hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Voltar ao Dashboard
        </a>
    </div>
</div>
