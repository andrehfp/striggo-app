<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    Olá, {{ $user->name }}! 👋
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Continue sua jornada de estudos para o Exame de Suficiência CFC
                </p>
            </div>

            <!-- Progress & Streak Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <livewire:progress-bar />
                <livewire:streak-counter />
            </div>

            <!-- Daily Goal Section -->
            <div class="mb-8">
                <livewire:daily-goal />
            </div>

            <!-- Stats Section -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Suas Estatísticas</h3>
                <livewire:user-stats />
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Practice Mode -->
                <a href="{{ route('practice') }}" class="block">
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg shadow-lg p-6 text-white hover:shadow-xl transition-shadow">
                        <div class="text-4xl mb-3">🎯</div>
                        <h3 class="text-xl font-bold mb-2">Modo Prática</h3>
                        <p class="text-sm opacity-90">
                            Responda questões aleatórias e ganhe XP
                        </p>
                    </div>
                </a>

                <!-- Simulated Test -->
                <a href="{{ route('simulated') }}" class="block">
                    <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-lg shadow-lg p-6 text-white hover:shadow-xl transition-shadow">
                        <div class="text-4xl mb-3">📝</div>
                        <h3 class="text-xl font-bold mb-2">Modo Simulado</h3>
                        <p class="text-sm opacity-90">
                            Faça uma prova completa com 50 questões
                        </p>
                    </div>
                </a>

                <!-- Statistics -->
                <a href="{{ route('statistics') }}" class="block">
                    <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-lg shadow-lg p-6 text-white hover:shadow-xl transition-shadow">
                        <div class="text-4xl mb-3">📊</div>
                        <h3 class="text-xl font-bold mb-2">Estatísticas</h3>
                        <p class="text-sm opacity-90">
                            Veja seu desempenho detalhado
                        </p>
                    </div>
                </a>
            </div>

            <!-- Recent Badges -->
            @if($user->badges()->exists())
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Conquistas Recentes</h3>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex flex-wrap gap-4">
                            @foreach($user->badges()->latest('user_badges.created_at')->take(5)->get() as $badge)
                                <div class="flex items-center bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg px-4 py-2">
                                    <span class="text-2xl mr-2">{{ $badge->icon }}</span>
                                    <div>
                                        <p class="font-semibold text-sm text-gray-900 dark:text-gray-100">{{ $badge->name }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $badge->description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
