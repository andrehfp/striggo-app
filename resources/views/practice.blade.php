<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Simple Header -->
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-xl font-semibold text-gray-900">Modo Prática</h1>
                <a href="{{ route('dashboard') }}"
                   class="text-sm text-gray-500 hover:text-gray-900 transition-colors">
                    Voltar
                </a>
            </div>

            <!-- Practice Session (10 questions) -->
            <livewire:practice-session :question-count="10" />

        </div>
    </div>
</x-app-layout>
