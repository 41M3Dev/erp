@extends('layouts.app')

@section('title', 'Finances — ERP')

@section('content')
    @php
        $totalRevenus = $finances->where('type_operation', 'revenu')->sum('montant');
        $totalDepenses = $finances->where('type_operation', 'dépense')->sum('montant');
        $totalFactures = $finances->where('type_operation', 'facture')->sum('montant');
        $typeColors = ['revenu' => 'emerald', 'dépense' => 'red', 'facture' => 'blue', 'taxe' => 'amber'];
        $statutColors = ['Payé' => 'emerald', 'En attente' => 'amber', 'Annulé' => 'red'];
    @endphp

    <!-- Header de page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center gap-1.5 text-sm text-slate-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-700 transition-colors">Accueil</a>
                <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                <span class="text-slate-700">Finances</span>
            </nav>
            <h1 class="text-xl font-semibold text-slate-900">Finances</h1>
        </div>
        <a href="{{ route('finances.create') }}"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <x-icon name="plus" />
            Nouvelle entrée
        </a>
    </div>

    @include('partials.flash')

    <!-- Résumé financier -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 flex items-center gap-4">
            <span class="bg-indigo-50 text-indigo-600 rounded-md p-2">
                <x-icon name="trending-up" class="w-5 h-5" />
            </span>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($totalRevenus, 0, ',', ' ') }}&nbsp;€</p>
                <p class="text-sm text-slate-500">Revenus</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 flex items-center gap-4">
            <span class="bg-indigo-50 text-indigo-600 rounded-md p-2">
                <x-icon name="trending-down" class="w-5 h-5" />
            </span>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($totalDepenses, 0, ',', ' ') }}&nbsp;€</p>
                <p class="text-sm text-slate-500">Dépenses</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 flex items-center gap-4">
            <span class="bg-indigo-50 text-indigo-600 rounded-md p-2">
                <x-icon name="file-text" class="w-5 h-5" />
            </span>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($totalFactures, 0, ',', ' ') }}&nbsp;€</p>
                <p class="text-sm text-slate-500">Factures</p>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="flex flex-col sm:flex-row gap-4 mb-4">
        <div class="relative w-full sm:max-w-sm">
            <x-icon name="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
            <input type="text" id="searchInput" placeholder="Rechercher par description..."
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
                            Type</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Description</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Montant</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Date</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Statut</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Référence</th>
                        <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Actions</th>
                    </tr>
                </thead>
                <tbody id="financeList">
                    @forelse ($finances as $finance)
                        <tr class="group border-b border-slate-100 last:border-0 hover:bg-slate-50 finance-item"
                            data-description="{{ strtolower($finance->description ?? '') }}">
                            <td class="px-6 py-4">
                                <x-badge :color="$typeColors[strtolower($finance->type_operation)] ?? 'slate'"
                                    class="capitalize">
                                    {{ $finance->type_operation }}
                                </x-badge>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700 max-w-xs truncate"
                                title="{{ $finance->description }}">
                                {{ $finance->description ?? '—' }}
                            </td>
                            <td
                                class="px-6 py-4 text-sm font-medium whitespace-nowrap {{ strtolower($finance->type_operation) === 'revenu' ? 'text-emerald-600' : (strtolower($finance->type_operation) === 'dépense' ? 'text-red-600' : 'text-slate-900') }}">
                                {{ strtolower($finance->type_operation) === 'revenu' ? '+' : (strtolower($finance->type_operation) === 'dépense' ? '-' : '') }}{{ number_format($finance->montant, 2, ',', ' ') }}&nbsp;€
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($finance->date_operation)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <x-badge :color="$statutColors[$finance->statut] ?? 'slate'">
                                    {{ $finance->statut }}
                                </x-badge>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $finance->reference_facture ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <div
                                    class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 focus-within:opacity-100 transition-opacity">
                                    <a href="{{ route('finances.edit', $finance->id_finance) }}" title="Modifier"
                                        class="p-2 rounded-md text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                                        <x-icon name="pencil" />
                                    </a>
                                    <form action="{{ route('finances.destroy', $finance->id_finance) }}" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer cette entrée ?')">
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
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-slate-500">
                                Aucune entrée financière trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('.finance-item').forEach(item => {
                const desc = item.getAttribute('data-description') || '';
                item.style.display = desc.includes(searchTerm) ? '' : 'none';
            });
        }

        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('resetFilters').addEventListener('click', () => {
            document.getElementById('searchInput').value = '';
            filterTable();
        });
    </script>
@endsection
