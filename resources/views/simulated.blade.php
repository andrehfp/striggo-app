<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modo Simulado
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Voltar ao Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Simulated Exam Session (50 questions) -->
            <livewire:practice-session :question-count="50" />
        </div>
    </div>
</x-app-layout>
