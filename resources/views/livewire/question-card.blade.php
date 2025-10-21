<div class="w-full max-w-3xl mx-auto">
    @if($question)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden" wire:key="question-{{ $question->id }}-{{ md5(json_encode($shuffledOptions)) }}">

            <!-- Question Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <span class="inline-flex items-center gap-2 text-xs font-medium text-gray-600">
                    <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                    </svg>
                    {{ $question->categoria }}
                </span>
                <span class="text-xs text-gray-400">#{{ $question->numero }}</span>
            </div>

            <!-- Question Text -->
            <div class="px-6 py-6 bg-gradient-to-br from-gray-50 to-white">
                <p class="text-base leading-relaxed text-gray-900 whitespace-pre-line">{{ $question->enunciado }}</p>
            </div>

            <!-- Answer Options -->
            <div class="px-6 py-4 space-y-2">
                @foreach((count($shuffledOptions) > 0 ? $shuffledOptions : ['A', 'B', 'C', 'D']) as $option)
                    <button
                        wire:click="selectAnswer('{{ $option }}')"
                        @disabled($answered)
                        class="w-full text-left p-4 rounded-xl transition-all duration-200 group
                            @if($answered)
                                @if($option === $question->resposta_correta)
                                    bg-emerald-50 border-2 border-emerald-500 shadow-sm
                                @elseif($option === $selectedAnswer && !$wasCorrect)
                                    bg-red-50 border-2 border-red-500 shadow-sm
                                @else
                                    bg-gray-50 border border-gray-200 opacity-60
                                @endif
                            @else
                                @if($selectedAnswer === $option)
                                    bg-primary-50 border-2 border-primary-500 shadow-md
                                @else
                                    bg-white border border-gray-200 hover:border-primary-300 hover:bg-gray-50 hover:shadow-sm
                                @endif
                            @endif
                        "
                    >
                        <div class="flex items-start gap-3">
                            <!-- Option Letter -->
                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg font-bold text-sm transition-colors
                                @if($answered && $option === $question->resposta_correta)
                                    bg-emerald-500 text-white
                                @elseif($answered && $option === $selectedAnswer && !$wasCorrect)
                                    bg-red-500 text-white
                                @elseif(!$answered && $selectedAnswer === $option)
                                    bg-primary-500 text-white
                                @else
                                    bg-gray-100 text-gray-700 group-hover:bg-primary-100 group-hover:text-primary-700
                                @endif
                            ">
                                {{ $option }}
                            </div>

                            <!-- Option Text -->
                            <span class="flex-1 text-sm text-gray-900 leading-relaxed pt-1">
                                {{ $question->{'opcao_' . strtolower($option)} }}
                            </span>

                            <!-- Check/Cross Icon -->
                            @if($answered && $option === $question->resposta_correta)
                                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @elseif($answered && $option === $selectedAnswer && !$wasCorrect)
                                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>

            <!-- Feedback & Explanation (appears inline after answering) -->
            @if($answered)
                <div class="px-6 pb-2 space-y-2">
                    <!-- Feedback Badge -->
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ $wasCorrect ? 'bg-emerald-50 border border-emerald-200' : 'bg-red-50 border border-red-200' }}">
                        <div class="text-2xl">
                            @if($wasCorrect) 🎉 @else 💪 @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold {{ $wasCorrect ? 'text-emerald-900' : 'text-red-900' }}">
                                @if($wasCorrect)
                                    Excelente!
                                @else
                                    Não foi dessa vez
                                @endif
                            </p>
                            <p class="text-xs {{ $wasCorrect ? 'text-emerald-700' : 'text-red-700' }}">
                                +{{ $xpEarned }} XP
                            </p>
                        </div>
                    </div>

                    <!-- Explanation -->
                    @if($question->explicacao)
                        <div class="p-4 {{ $wasCorrect ? 'bg-emerald-50/50 border border-emerald-200' : 'bg-red-50/50 border border-red-200' }} rounded-xl">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 {{ $wasCorrect ? 'text-emerald-600' : 'text-red-600' }} mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold {{ $wasCorrect ? 'text-emerald-900' : 'text-red-900' }} mb-1">
                                        Explicação
                                    </p>
                                    <p class="text-xs {{ $wasCorrect ? 'text-emerald-800' : 'text-red-800' }} leading-relaxed">
                                        {{ $question->explicacao }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Action Button -->
            <div class="px-6 pb-6 pt-4 {{ $answered ? '' : 'border-t border-gray-100' }}">
                @if(!$answered)
                    <button
                        wire:click="submitAnswer"
                        @disabled(!$selectedAnswer)
                        class="w-full py-3.5 rounded-xl font-semibold text-white transition-all duration-200
                            @if($selectedAnswer)
                                bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700 shadow-lg hover:shadow-xl
                            @else
                                bg-gray-300 cursor-not-allowed
                            @endif
                        "
                    >
                        @if($selectedAnswer)
                            Confirmar Resposta
                        @else
                            Selecione uma alternativa
                        @endif
                    </button>
                @else
                    <button
                        wire:click="nextQuestion"
                        class="w-full py-3.5 bg-gradient-to-r {{ $wasCorrect ? 'from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700' : 'from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700' }} text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        @if($isLastQuestion)
                            Ver Resultados
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        @else
                            Próxima Questão
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        @endif
                    </button>
                @endif
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p class="text-gray-600 text-lg">Nenhuma questão disponível no momento</p>
        </div>
    @endif
</div>
