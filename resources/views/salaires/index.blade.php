@extends('layouts.app')

@section('title', 'Salaires — ERP')

@section('content')
    <!-- Header de page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center gap-1.5 text-sm text-slate-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-700 transition-colors">Accueil</a>
                <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                <span class="text-slate-700">Salaires</span>
            </nav>
            <h1 class="text-xl font-semibold text-slate-900">Salaires</h1>
        </div>
        <a href="{{ route('salaires.create') }}"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <x-icon name="plus" />
            Nouveau salaire
        </a>
    </div>

    @include('partials.flash')

    <!-- Filtres -->
    <div class="flex flex-col sm:flex-row gap-4 mb-4">
        <div class="relative w-full sm:max-w-sm">
            <x-icon name="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
            <input type="text" id="searchInput" placeholder="Rechercher par nom d'employé..."
                class="w-full bg-white border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        </div>
        <button id="resetFilters" type="button"
            class="bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors">
            Réinitialiser
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Employé</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Montant</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Période</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Date création</th>
                        <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Actions</th>
                    </tr>
                </thead>
                <tbody id="salariesList">
                    @forelse ($salaires as $salaire)
                        <tr class="group border-b border-slate-100 last:border-0 hover:bg-slate-50 salary-item"
                            data-name="{{ strtolower($salaire->employe->nom ?? '') }} {{ strtolower($salaire->employe->prenom ?? '') }}">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                {{ $salaire->employe->nom ?? 'N/A' }} {{ $salaire->employe->prenom ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 whitespace-nowrap">
                                {{ number_format($salaire->montant, 2, ',', ' ') }}&nbsp;€
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($salaire->date_debut)->format('d/m/Y') }}
                                &rarr;
                                {{ $salaire->date_fin ? \Carbon\Carbon::parse($salaire->date_fin)->format('d/m/Y') : '…' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap">
                                {{ $salaire->date_creation ? \Carbon\Carbon::parse($salaire->date_creation)->format('d/m/Y') : '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <div
                                    class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 focus-within:opacity-100 transition-opacity">
                                    <a href="{{ route('salaires.edit', $salaire->id_salaire) }}" title="Modifier"
                                        class="p-2 rounded-md text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                                        <x-icon name="pencil" />
                                    </a>
                                    <form action="{{ route('salaires.destroy', $salaire->id_salaire) }}" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer ce salaire ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Supprimer"
                                            class="p-2 rounded-md text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                            <x-icon name="trash" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-500">
                                Aucun salaire trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Total salaires -->
    <div class="text-right mt-4">
        <p class="text-sm text-slate-500">Masse salariale actuelle</p>
        <p class="text-2xl font-bold text-slate-900">{{ number_format($totalSalaries, 2, ',', ' ') }}&nbsp;€</p>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const resetButton = document.getElementById('resetFilters');

        searchInput.addEventListener('input', filterSalaries);
        resetButton.addEventListener('click', () => {
            searchInput.value = '';
            filterSalaries();
        });

        function filterSalaries() {
            const term = searchInput.value.toLowerCase();
            document.querySelectorAll('.salary-item').forEach(item => {
                const name = item.getAttribute('data-name') || '';
                item.style.display = name.includes(term) ? '' : 'none';
            });
        }
    </script>
@endsection
