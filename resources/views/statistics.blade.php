<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Estatísticas
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Voltar ao Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Overall Stats -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Desempenho Geral</h3>
                <livewire:user-stats />
            </div>

            <!-- Progress Card -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <livewire:progress-bar />
                <livewire:streak-counter />
            </div>

            <!-- Category Performance -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Desempenho por Categoria</h3>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Categoria
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Respondidas
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acertos
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Precisão
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Progresso
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($categoryStats as $cat)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $cat['category'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $cat['answered_questions'] }} / {{ $cat['total_questions'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-green-600 font-semibold">{{ $cat['correct_answers'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($cat['accuracy'] >= 80) bg-green-100 text-green-800
                                            @elseif($cat['accuracy'] >= 60) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif
                                        ">
                                            {{ number_format($cat['accuracy'], 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div
                                                class="bg-indigo-600 h-2 rounded-full"
                                                style="width: {{ $cat['total_questions'] > 0 ? ($cat['answered_questions'] / $cat['total_questions']) * 100 : 0 }}%"
                                            ></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Achievements -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Conquistas ({{ $user->badges()->count() }}/15)</h3>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @php
                            $allBadges = \App\Models\Badge::all();
                            $userBadgeIds = $user->badges->pluck('id')->toArray();
                        @endphp

                        @foreach($allBadges as $badge)
                            @php
                                $hasBadge = in_array($badge->id, $userBadgeIds);
                            @endphp
                            <div class="text-center p-4 rounded-lg border-2 transition-all
                                @if($hasBadge)
                                    border-yellow-300 bg-yellow-50
                                @else
                                    border-gray-200 bg-gray-50 opacity-40
                                @endif
                            ">
                                <div class="text-4xl mb-2 {{ $hasBadge ? '' : 'grayscale' }}">{{ $badge->icon }}</div>
                                <p class="font-semibold text-sm text-gray-900">{{ $badge->name }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ $badge->description }}</p>
                                @if($hasBadge)
                                    <p class="text-xs text-green-600 mt-2">✓ Desbloqueada</p>
                                @else
                                    <p class="text-xs text-gray-400 mt-2">🔒 Bloqueada</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
