<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modo Prática
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Voltar ao Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Progress Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <livewire:progress-bar />
                <livewire:daily-goal />
                <livewire:streak-counter />
            </div>

            <!-- Question Card -->
            <livewire:question-card />

            <!-- Tips Section -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-start">
                    <span class="text-2xl mr-3">💡</span>
                    <div>
                        <h4 class="font-semibold text-blue-900 mb-2">Dicas para Estudar Melhor</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Leia atentamente toda a questão antes de escolher a resposta</li>
                            <li>• Foque nas categorias onde você tem mais dificuldade</li>
                            <li>• Estude um pouco todos os dias para manter o streak</li>
                            <li>• Complete sua meta diária de {{ auth()->user()->getOrCreateProgress()->daily_goal }} questões</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
