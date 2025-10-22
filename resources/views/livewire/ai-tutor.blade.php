<div style="display: contents;">
    <!-- Floating Button -->
    <button
        wire:click="toggleChat"
        class="fixed bottom-8 right-8 w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-200 flex items-center justify-center"
        style="z-index: 99999; position: fixed !important; bottom: 32px !important; right: 32px !important;"
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
        class="bg-white shadow-2xl flex flex-col transition-transform duration-300 ease-in-out"
        style="position: fixed !important; top: 0 !important; right: 0 !important; width: 400px !important; height: 100vh !important; z-index: 9998; transform: {{ $isOpen ? 'translateX(0)' : 'translateX(100%)' }};"
    >
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-500 via-primary-600 to-indigo-600 text-white p-5 flex items-center justify-between shadow-lg">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center ring-2 ring-white/40 shadow-md">
                    <span class="text-2xl">🤖</span>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Tutor de IA</h3>
                    <p class="text-xs text-white/90">Online • Pronto para ajudar</p>
                </div>
            </div>
            <div class="flex items-center gap-1">
                <button
                    wire:click="startNewConversation"
                    class="p-2.5 hover:bg-white/15 rounded-xl transition-all duration-200 hover:scale-105 active:scale-95"
                    title="Nova conversa"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
                <button
                    wire:click="toggleChat"
                    class="p-2.5 hover:bg-white/15 rounded-xl transition-all duration-200 hover:scale-105 active:scale-95"
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
                <div class="flex {{ $message['role'] === 'user' ? 'justify-end' : 'justify-start' }} animate-fade-in">
                    <div class="flex items-end gap-2.5 max-w-[85%] {{ $message['role'] === 'user' ? 'flex-row-reverse' : 'flex-row' }}">
                        <!-- Avatar -->
                        <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 {{ $message['role'] === 'user' ? 'bg-gradient-to-br from-primary-500 to-indigo-600 ring-2 ring-primary-200 shadow-lg' : 'bg-gray-700 ring-2 ring-gray-300 shadow-lg' }}">
                            @if($message['role'] === 'user')
                                <span class="text-lg">👤</span>
                            @else
                                <span class="text-lg">🤖</span>
                            @endif
                        </div>

                        <!-- Message Bubble -->
                        <div class="group">
                            <div class="{{ $message['role'] === 'user' ? 'bg-gradient-to-r from-primary-500 via-primary-600 to-indigo-600 text-white shadow-lg' : 'bg-white text-gray-900 border-2 border-gray-200 shadow-md' }} rounded-2xl px-4 py-3.5 hover:shadow-xl transition-all">
                                <p class="text-sm whitespace-pre-wrap leading-relaxed {{ $message['role'] === 'user' ? 'font-medium' : '' }}">{{ $message['content'] }}</p>
                            </div>
                            <span class="text-xs {{ $message['role'] === 'user' ? 'text-gray-500' : 'text-gray-500' }} mt-1.5 block {{ $message['role'] === 'user' ? 'text-right' : 'text-left' }} px-2">{{ $message['created_at'] }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center h-full">
                    <div class="text-center py-12 px-6">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-primary-100 to-indigo-100 rounded-full flex items-center justify-center shadow-md">
                            <span class="text-4xl">💬</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-700 mb-1">Nenhuma mensagem ainda</p>
                        <p class="text-xs text-gray-500">Comece uma conversa com seu tutor de IA</p>
                    </div>
                </div>
            @endforelse

            <!-- Loading Indicator -->
            @if($isLoading)
                <div class="flex justify-start animate-fade-in">
                    <div class="flex items-end gap-2.5 max-w-[85%]">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 bg-gray-700 ring-2 ring-gray-300 shadow-lg">
                            <span class="text-lg">🤖</span>
                        </div>
                        <div class="bg-white border-2 border-gray-200 rounded-2xl px-5 py-4 shadow-md">
                            <div class="flex gap-1.5">
                                <span class="w-2.5 h-2.5 bg-primary-500 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                                <span class="w-2.5 h-2.5 bg-primary-600 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                                <span class="w-2.5 h-2.5 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white border-t border-gray-100">
            <form wire:submit.prevent="sendMessage" class="flex gap-2.5">
                <input
                    type="text"
                    wire:model="userInput"
                    placeholder="Digite sua mensagem..."
                    class="flex-1 px-4 py-3.5 border-2 border-gray-300 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all bg-white text-gray-900 placeholder-gray-400 font-medium"
                    {{ $isLoading ? 'disabled' : '' }}
                />
                <button
                    type="submit"
                    class="px-5 py-3.5 bg-gradient-to-r from-primary-500 via-primary-600 to-indigo-600 text-white rounded-2xl hover:shadow-xl transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center shadow-lg active:scale-95 min-w-[56px] font-semibold"
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
            <p class="text-xs text-gray-400 mt-3 text-center flex items-center justify-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                </svg>
                Powered by OpenAI
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
