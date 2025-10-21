<div class="w-full">
    @if($question)
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-8"
             wire:key="question-{{ $question->id }}-{{ md5(json_encode($shuffledOptions)) }}">

            <!-- Metadata - Discreto -->
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                    {{ $question->categoria }}
                </span>
                <span class="text-xs text-gray-400 dark:text-gray-500">
                    #{{ $question->numero }}
                </span>
            </div>

            <!-- Question Text - Protagonista -->
            <div class="mb-8">
                <p class="text-lg leading-relaxed text-gray-900 dark:text-gray-100 whitespace-pre-line">
                    {{ $question->enunciado }}
                </p>
            </div>

            <!-- Answer Options - Limpo -->
            <div class="space-y-3 mb-8">
                @foreach((count($shuffledOptions) > 0 ? $shuffledOptions : ['A', 'B', 'C', 'D']) as $option)
                    <button
                        wire:click="selectAnswer('{{ $option }}')"
                        @disabled($answered)
                        class="w-full text-left p-4 rounded-lg border-2 transition-all
                            @if($answered)
                                @if($option === $question->resposta_correta)
                                    border-green-600 bg-green-50 dark:bg-green-900/10
                                @elseif($option === $selectedAnswer && !$wasCorrect)
                                    border-red-600 bg-red-50 dark:bg-red-900/10
                                @else
                                    border-gray-200 dark:border-gray-700 opacity-50
                                @endif
                            @else
                                @if($selectedAnswer === $option)
                                    border-indigo-600 bg-indigo-50 dark:bg-indigo-900/10
                                @else
                                    border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600
                                @endif
                            @endif
                        "
                    >
                        <div class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-7 h-7 flex items-center justify-center rounded text-sm font-medium
                                @if($answered && $option === $question->resposta_correta)
                                    bg-green-600 text-white
                                @elseif($answered && $option === $selectedAnswer && !$wasCorrect)
                                    bg-red-600 text-white
                                @elseif(!$answered && $selectedAnswer === $option)
                                    bg-indigo-600 text-white
                                @else
                                    text-gray-600 dark:text-gray-400
                                @endif
                            ">
                                {{ $option }}
                            </span>
                            <span class="flex-1 text-gray-900 dark:text-gray-100">
                                {{ $question->{'opcao_' . strtolower($option)} }}
                            </span>
                        </div>
                    </button>
                @endforeach
            </div>

            <!-- Feedback - Discreto mas claro -->
            @if($answered)
                <div class="mb-6 p-5 rounded-lg border-2
                    @if($wasCorrect) border-green-600 bg-green-50 dark:bg-green-900/10 @else border-red-600 bg-red-50 dark:bg-red-900/10 @endif
                ">
                    <!-- Result Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="font-semibold text-lg @if($wasCorrect) text-green-900 dark:text-green-100 @else text-red-900 dark:text-red-100 @endif">
                                @if($wasCorrect)
                                    Correto
                                @else
                                    Incorreto
                                @endif
                            </p>
                            <p class="text-sm @if($wasCorrect) text-green-700 dark:text-green-300 @else text-red-700 dark:text-red-300 @endif">
                                +{{ $xpEarned }} XP
                            </p>
                        </div>
                    </div>

                    <!-- Explanation - Sempre visível, bem formatada -->
                    @if($question->explicacao)
                        <div class="pt-4 border-t @if($wasCorrect) border-green-200 dark:border-green-800 @else border-red-200 dark:border-red-800 @endif">
                            <p class="text-sm font-medium @if($wasCorrect) text-green-900 dark:text-green-100 @else text-red-900 dark:text-red-100 @endif mb-2">
                                Explicação:
                            </p>
                            <p class="text-sm @if($wasCorrect) text-green-800 dark:text-green-200 @else text-red-800 dark:text-red-200 @endif leading-relaxed">
                                {{ $question->explicacao }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Next Button - Discreto -->
                <button
                    wire:click="nextQuestion"
                    class="w-full py-3 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors"
                >
                    Próxima questão →
                </button>
            @endif

            <!-- Submit Button -->
            @if(!$answered)
                <button
                    wire:click="submitAnswer"
                    @disabled(!$selectedAnswer)
                    class="w-full py-4 rounded-lg font-semibold transition-colors
                        @if($selectedAnswer)
                            bg-indigo-600 hover:bg-indigo-700 text-white
                        @else
                            bg-gray-200 dark:bg-gray-700 text-gray-400 dark:text-gray-500 cursor-not-allowed
                        @endif
                    "
                >
                    Confirmar Resposta
                </button>
            @endif
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
            <p class="text-gray-500 dark:text-gray-400">Nenhuma questão disponível no momento.</p>
        </div>
    @endif
</div>
