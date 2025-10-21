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
            <div class="bg-white rounded-lg shadow-lg p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="text-6xl mb-4">📝</div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Modo Simulado</h1>
                    <p class="text-gray-600">Pratique como se estivesse fazendo a prova real</p>
                </div>

                <!-- Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-6 text-center">
                        <div class="text-3xl mb-2">📊</div>
                        <p class="text-2xl font-bold text-indigo-900">50</p>
                        <p class="text-sm text-indigo-700">Questões</p>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                        <div class="text-3xl mb-2">⏱️</div>
                        <p class="text-2xl font-bold text-green-900">4h</p>
                        <p class="text-sm text-green-700">Tempo Limite</p>
                    </div>
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 text-center">
                        <div class="text-3xl mb-2">🎯</div>
                        <p class="text-2xl font-bold text-purple-900">100%</p>
                        <p class="text-sm text-purple-700">Como na Prova Real</p>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                    <h3 class="font-semibold text-yellow-900 mb-3 flex items-center">
                        <span class="text-2xl mr-2">⚠️</span>
                        Instruções Importantes
                    </h3>
                    <ul class="space-y-2 text-sm text-yellow-800">
                        <li>• Você terá <strong>4 horas</strong> para responder 50 questões</li>
                        <li>• Não é possível pausar o simulado uma vez iniciado</li>
                        <li>• As questões serão apresentadas na mesma ordem da prova</li>
                        <li>• Você pode revisar suas respostas antes de finalizar</li>
                        <li>• Ao finalizar, você receberá o resultado imediato</li>
                    </ul>
                </div>

                <!-- Start Button -->
                <div class="text-center">
                    <button
                        class="px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-bold text-lg rounded-lg shadow-lg transition-colors"
                        onclick="alert('Modo Simulado será implementado em breve! 🚀')"
                    >
                        Iniciar Simulado 🚀
                    </button>
                    <p class="text-sm text-gray-500 mt-4">
                        Certifique-se de estar em um ambiente tranquilo antes de começar
                    </p>
                </div>

                <!-- Coming Soon Notice -->
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                    <p class="text-sm text-blue-800">
                        <strong>Em Desenvolvimento:</strong> O Modo Simulado será implementado em breve com cronômetro, revisão de questões e relatório detalhado.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
