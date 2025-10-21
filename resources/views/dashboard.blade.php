<x-app-layout>
    <div class="py-8 sm:py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Section -->
            <div class="mb-12 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-3">
                    Olá, {{ $user->name }}!
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Continue sua jornada de estudos para o Exame de Suficiência CFC
                </p>
            </div>

            <!-- Main CTA -->
            <div class="mb-12">
                <a href="{{ route('practice') }}" class="group block">
                    <div class="relative bg-gradient-to-r from-primary-500 via-primary-600 to-indigo-600 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
                        </div>

                        <div class="relative px-8 py-12 sm:px-12 sm:py-16 flex items-center justify-between">
                            <div class="flex-1">
                                <div class="inline-flex items-center px-4 py-2 bg-white/20 rounded-full text-white text-sm font-medium mb-4">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Modo Adaptativo Ativo
                                </div>
                                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3">
                                    Começar Prática
                                </h2>
                                <p class="text-primary-50 text-lg mb-0">
                                    Questões personalizadas baseadas no seu desempenho
                                </p>
                            </div>
                            <div class="hidden sm:block">
                                <svg class="w-16 h-16 text-white/30 group-hover:text-white/50 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Progress Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
                <livewire:progress-bar />
                <livewire:daily-goal />
                <livewire:streak-counter />
            </div>

            <!-- Stats Overview -->
            <div class="mb-12">
                <livewire:user-stats />
            </div>

            <!-- Weak Categories -->
            <div class="mb-12">
                <livewire:weak-categories />
            </div>

            <!-- Secondary Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-12">
                <a href="{{ route('simulated') }}" class="group">
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-2 border-transparent hover:border-primary-200">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-xl flex items-center justify-center text-2xl">
                                📝
                            </div>
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Modo Simulado</h3>
                        <p class="text-gray-600">
                            Prova completa com 50 questões cronometradas
                        </p>
                    </div>
                </a>

                <a href="{{ route('statistics') }}" class="group">
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-2 border-transparent hover:border-primary-200">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-violet-100 to-violet-200 rounded-xl flex items-center justify-center text-2xl">
                                📊
                            </div>
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Estatísticas Detalhadas</h3>
                        <p class="text-gray-600">
                            Análise completa do seu desempenho por categoria
                        </p>
                    </div>
                </a>
            </div>

            <!-- Recent Badges -->
            @if($user->badges()->exists())
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Conquistas Recentes</h3>
                    <div class="flex flex-wrap gap-4">
                        @foreach($user->badges()->latest('user_badges.created_at')->take(5)->get() as $badge)
                            <div class="flex items-center bg-gradient-to-br from-amber-50 to-yellow-50 border-2 border-amber-200 rounded-xl px-5 py-3 hover:scale-105 transition-transform">
                                <span class="text-3xl mr-3">{{ $badge->icon }}</span>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $badge->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $badge->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
