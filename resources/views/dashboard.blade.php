<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <!-- User Progress Header - Minimalista -->
            <div class="mb-12">
                <div class="flex items-baseline gap-3 mb-2">
                    <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ $user->name }}
                    </h1>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Nível {{ $user->getOrCreateProgress()->level }}
                    </span>
                </div>
                <p class="text-gray-600 dark:text-gray-400">
                    Continue estudando para o Exame de Suficiência CFC
                </p>
            </div>

            <!-- Core Metrics - Linha única compacta -->
            <div class="grid grid-cols-3 gap-4 mb-12">
                <livewire:progress-bar />
                <livewire:daily-goal />
                <livewire:streak-counter />
            </div>

            <!-- Primary Action - Destaque claro -->
            <div class="mb-8">
                <a href="{{ route('practice') }}"
                   class="block bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg p-6 transition-colors group">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold mb-1">Começar Prática</h2>
                            <p class="text-indigo-100 text-sm">
                                Responda questões adaptativas baseadas no seu desempenho
                            </p>
                        </div>
                        <svg class="w-6 h-6 text-indigo-200 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Secondary Actions - Simples -->
            <div class="grid grid-cols-2 gap-4 mb-12">
                <a href="{{ route('simulated') }}"
                   class="block border-2 border-gray-200 dark:border-gray-700 hover:border-indigo-600 dark:hover:border-indigo-500 rounded-lg p-5 transition-colors group">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                        Modo Simulado
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Prova completa com 50 questões
                    </p>
                </a>

                <a href="{{ route('statistics') }}"
                   class="block border-2 border-gray-200 dark:border-gray-700 hover:border-indigo-600 dark:hover:border-indigo-500 rounded-lg p-5 transition-colors group">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                        Estatísticas
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Desempenho detalhado por categoria
                    </p>
                </a>
            </div>

            <!-- Overall Stats - Compacto -->
            <div class="mb-8">
                <livewire:user-stats />
            </div>

            <!-- Weak Categories - Foco pedagógico -->
            <livewire:weak-categories />

        </div>
    </div>
</x-app-layout>
