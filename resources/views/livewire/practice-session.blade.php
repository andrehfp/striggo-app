<div class="max-w-4xl mx-auto px-4">
    @if(!$sessionComplete)
        <!-- Session Progress Bar -->
        <div class="mb-8 bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700">
                    Questão {{ $progress['current'] }} de {{ $progress['total'] }}
                </span>
                <span class="text-sm font-semibold text-primary-600">
                    {{ round($progress['percentage']) }}%
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                <div
                    class="bg-gradient-to-r from-primary-500 to-indigo-500 h-3 rounded-full transition-all duration-500 ease-out"
                    style="width: {{ $progress['percentage'] }}%"
                ></div>
            </div>
            <div class="mt-3 text-xs text-gray-500 text-center">
                {{ $correctCount }} corretas de {{ count($sessionAnswers) }} respondidas
            </div>
        </div>

        <!-- Question Card -->
        @if($currentQuestion)
            <livewire:question-card
                :question-id="$currentQuestion->id"
                :is-session-mode="true"
                :key="'question-'.$currentQuestion->id.'-'.$currentQuestionIndex"
                wire:key="question-{{ $currentQuestion->id }}-{{ $currentQuestionIndex }}"
            />
        @endif
    @else
        <!-- Session Summary -->
        <livewire:session-summary
            :total-questions="$totalQuestions"
            :correct-count="$correctCount"
            :total-xp-earned="$totalXpEarned"
            :duration="$this->getSessionDuration()"
            :session-answers="$sessionAnswers"
            :question-ids="$questionIds"
        />
    @endif
</div>
