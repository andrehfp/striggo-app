<div>
    <!-- Floating Button -->
    <button
        wire:click="toggleChat"
        class="fixed bottom-6 right-6 z-50 w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-200 flex items-center justify-center group"
        aria-label="Abrir tutor de IA"
    >
        @if($isOpen)
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        @else
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
        @endif

        <!-- Badge for "NEW" indicator -->
        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-white group-hover:animate-pulse"></span>
    </button>

    <!-- Chat Panel -->
    <div
        class="fixed bottom-0 right-0 z-40 w-full sm:w-[400px] h-[600px] bg-white shadow-2xl transition-transform duration-300 ease-in-out {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }} flex flex-col"
        style="border-top-left-radius: 1rem;"
    >
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-4 flex items-center justify-between" style="border-top-left-radius: 1rem;">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Tutor de IA</h3>
                    <p class="text-xs text-white/80">Sempre pronto para ajudar</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button
                    wire:click="startNewConversation"
                    class="p-2 hover:bg-white/10 rounded-lg transition-colors"
                    title="Nova conversa"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
                <button
                    wire:click="toggleChat"
                    class="p-2 hover:bg-white/10 rounded-lg transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div
            class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50"
            id="messages-container"
            x-data
            x-init="$nextTick(() => { $el.scrollTop = $el.scrollHeight })"
        >
            @forelse($messages as $message)
                <div class="flex {{ $message['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                    <div class="flex items-end gap-2 max-w-[85%] {{ $message['role'] === 'user' ? 'flex-row-reverse' : 'flex-row' }}">
                        <!-- Avatar -->
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 {{ $message['role'] === 'user' ? 'bg-indigo-500' : 'bg-purple-500' }}">
                            @if($message['role'] === 'user')
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            @endif
                        </div>

                        <!-- Message Bubble -->
                        <div class="{{ $message['role'] === 'user' ? 'bg-indigo-500 text-white' : 'bg-white text-gray-800' }} rounded-2xl px-4 py-3 shadow-sm">
                            <p class="text-sm whitespace-pre-wrap leading-relaxed">{{ $message['content'] }}</p>
                            <span class="text-xs {{ $message['role'] === 'user' ? 'text-indigo-100' : 'text-gray-400' }} mt-1 block">{{ $message['created_at'] }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-sm">Nenhuma mensagem ainda</p>
                </div>
            @endforelse

            <!-- Loading Indicator -->
            @if($isLoading)
                <div class="flex justify-start">
                    <div class="flex items-end gap-2 max-w-[85%]">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-purple-500">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <div class="bg-white rounded-2xl px-4 py-3 shadow-sm">
                            <div class="flex gap-1">
                                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white border-t border-gray-200">
            <form wire:submit.prevent="sendMessage" class="flex gap-2">
                <input
                    type="text"
                    wire:model="userInput"
                    placeholder="Digite sua mensagem..."
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none"
                    {{ $isLoading ? 'disabled' : '' }}
                />
                <button
                    type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                    {{ $isLoading ? 'disabled' : '' }}
                >
                    @if($isLoading)
                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    @endif
                </button>
            </form>
            <p class="text-xs text-gray-400 mt-2 text-center">
                Powered by OpenAI • Seu tutor pessoal de IA
            </p>
        </div>
    </div>
</div>

@script
<script>
    // Auto-scroll to bottom when new messages arrive
    $wire.on('message-sent', () => {
        const container = document.getElementById('messages-container');
        if (container) {
            setTimeout(() => {
                container.scrollTop = container.scrollHeight;
            }, 100);
        }
    });
</script>
@endscript
