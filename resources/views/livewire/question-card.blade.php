<div class="max-w-4xl mx-auto">
    @if($question)
        <div class="bg-white rounded-lg shadow-lg p-8" wire:key="question-{{ $question->id }}-{{ md5(json_encode($shuffledOptions)) }}">
            <!-- Question Number & Category -->
            <div class="flex justify-between items-center mb-6">
                <span class="text-sm font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">
                    {{ $question->categoria }}
                </span>
                <span class="text-sm text-gray-500">
                    Questão #{{ $question->numero }}
                </span>
            </div>

            <!-- Question Text -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $question->numero }}. Questão</h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $question->enunciado }}</p>
            </div>

            <!-- Answer Options -->
            <div class="space-y-3 mb-8">
                @foreach((count($shuffledOptions) > 0 ? $shuffledOptions : ['A', 'B', 'C', 'D']) as $option)
                    <button
                        wire:click="selectAnswer('{{ $option }}')"
                        @disabled($answered)
                        class="w-full text-left p-4 rounded-lg border-2 transition-all
                            @if($answered)
                                @if($option === $question->resposta_correta)
                                    border-green-500 bg-green-50
                                @elseif($option === $selectedAnswer && !$wasCorrect)
                                    border-red-500 bg-red-50
                                @else
                                    border-gray-200 bg-gray-50 opacity-60
                                @endif
                            @else
                                @if($selectedAnswer === $option)
                                    border-indigo-500 bg-indigo-50
                                @else
                                    border-gray-300 hover:border-indigo-300 hover:bg-gray-50
                                @endif
                            @endif
                        "
                    >
                        <div class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full text-sm font-semibold mr-3
                                @if($answered && $option === $question->resposta_correta)
                                    bg-green-500 text-white
                                @elseif($answered && $option === $selectedAnswer && !$wasCorrect)
                                    bg-red-500 text-white
                                @elseif(!$answered && $selectedAnswer === $option)
                                    bg-indigo-500 text-white
                                @else
                                    bg-gray-200 text-gray-700
                                @endif
                            ">
                                {{ $option }}
                            </span>
                            <span class="flex-1 pt-1">{{ $question->{'opcao_' . strtolower($option)} }}</span>

                            @if($answered && $option === $question->resposta_correta)
                                <span class="text-green-500 text-xl ml-2">✓</span>
                            @elseif($answered && $option === $selectedAnswer && !$wasCorrect)
                                <span class="text-red-500 text-xl ml-2">✗</span>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>

            <!-- Feedback Section -->
            @if($answered)
                <div class="mb-6 p-4 rounded-lg
                    @if($wasCorrect) bg-green-50 border border-green-200 @else bg-red-50 border border-red-200 @endif
                ">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">
                                @if($wasCorrect) 🎉 @else 💪 @endif
                            </span>
                            <div>
                                <p class="font-semibold @if($wasCorrect) text-green-800 @else text-red-800 @endif">
                                    @if($wasCorrect)
                                        Parabéns! Resposta correta!
                                    @else
                                        Não foi dessa vez. Continue estudando!
                                    @endif
                                </p>
                                <p class="text-sm @if($wasCorrect) text-green-600 @else text-red-600 @endif">
                                    Você ganhou <strong>{{ $xpEarned }} XP</strong>
                                </p>
                            </div>
                        </div>
                        <button
                            wire:click="nextQuestion"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold"
                        >
                            Próxima Questão →
                        </button>
                    </div>

                    <!-- Explanation -->
                    @if($question->explicacao)
                        <div class="mt-3 pt-3 border-t @if($wasCorrect) border-green-200 @else border-red-200 @endif">
                            <p class="text-sm font-semibold @if($wasCorrect) text-green-800 @else text-red-800 @endif mb-1">
                                📚 Explicação:
                            </p>
                            <p class="text-sm @if($wasCorrect) text-green-700 @else text-red-700 @endif leading-relaxed">
                                {{ $question->explicacao }}
                            </p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Submit Button -->
            @if(!$answered)
                <button
                    wire:click="submitAnswer"
                    @disabled(!$selectedAnswer)
                    class="w-full py-4 rounded-lg font-semibold text-white transition-colors
                        @if($selectedAnswer)
                            bg-indigo-600 hover:bg-indigo-700
                        @else
                            bg-gray-300 cursor-not-allowed
                        @endif
                    "
                >
                    Confirmar Resposta
                </button>
            @endif
        </div>
    @else
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <p class="text-gray-500">Nenhuma questão disponível no momento.</p>
        </div>
    @endif
</div>
