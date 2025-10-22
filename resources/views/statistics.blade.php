<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Estatísticas</h1>
                <a href="{{ route('dashboard') }}"
                   class="text-sm text-gray-500 hover:text-gray-900 transition-colors">
                    Voltar
                </a>
            </div>

            <!-- Overall Stats -->
            <div class="mb-12">
                <livewire:user-stats />
            </div>

            <!-- Progress Metrics -->
            <div class="grid grid-cols-2 gap-6 mb-12">
                <livewire:progress-bar />
                <livewire:streak-counter />
            </div>

            <!-- Category Performance -->
            <div class="mb-12">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    Desempenho por Categoria
                </h2>
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Categoria
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Respondidas
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acertos
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Precisão
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Progresso
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($categoryStats as $cat)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $cat['category'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="text-sm text-gray-600">
                                            {{ $cat['answered_questions'] }} / {{ $cat['total_questions'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="text-sm font-medium text-green-600">
                                            {{ $cat['correct_answers'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-sm font-semibold
                                            @if($cat['accuracy'] >= 80) text-green-600
                                            @elseif($cat['accuracy'] >= 60) text-yellow-600
                                            @else text-red-600
                                            @endif
                                        ">
                                            {{ number_format($cat['accuracy'], 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <span class="text-xs text-gray-500">
                                                {{ number_format(($cat['answered_questions'] / $cat['total_questions']) * 100, 0) }}%
                                            </span>
                                            <div class="w-24 bg-gray-200 rounded-full h-1.5">
                                                <div
                                                    class="bg-indigo-600 h-1.5 rounded-full"
                                                    style="width: {{ $cat['total_questions'] > 0 ? ($cat['answered_questions'] / $cat['total_questions']) * 100 : 0 }}%"
                                                ></div>
                                            </div>
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
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    Conquistas ({{ $user->badges()->count() }}/15)
                </h2>
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="grid grid-cols-3 md:grid-cols-5 gap-4">
                        @php
                            $allBadges = \App\Models\Badge::all();
                            $userBadgeIds = $user->badges->pluck('id')->toArray();
                        @endphp

                        @foreach($allBadges as $badge)
                            @php
                                $hasBadge = in_array($badge->id, $userBadgeIds);
                            @endphp
                            <div class="text-center p-4 rounded-lg border transition-all
                                @if($hasBadge)
                                    border-gray-300 bg-gray-50
                                @else
                                    border-gray-200 opacity-40
                                @endif
                            ">
                                <div class="text-3xl mb-2 {{ $hasBadge ? '' : 'grayscale' }}">
                                    {{ $badge->icon }}
                                </div>
                                <p class="text-xs font-medium text-gray-900 mb-1">
                                    {{ $badge->name }}
                                </p>
                                <p class="text-xs text-gray-600">
                                    {{ Str::limit($badge->description, 30) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
