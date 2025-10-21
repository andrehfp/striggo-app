<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Simple Header -->
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Modo Prática</h1>
                <a href="{{ route('dashboard') }}"
                   class="text-sm text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors">
                    Voltar
                </a>
            </div>

            <!-- Question Card - Protagonista -->
            <livewire:question-card />

            <!-- Minimal Daily Progress -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Meta diária: <span class="font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->getOrCreateProgress()->questions_today }}</span> / {{ auth()->user()->getOrCreateProgress()->daily_goal }} questões
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
