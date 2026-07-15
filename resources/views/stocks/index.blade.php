@extends('layouts.app')

@section('title', 'Stocks — ERP')

@section('content')
    <!-- Header de page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center gap-1.5 text-sm text-slate-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-700 transition-colors">Accueil</a>
                <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                <span class="text-slate-700">Stocks</span>
            </nav>
            <h1 class="text-xl font-semibold text-slate-900">Gestion du stock</h1>
        </div>
        <a href="{{ route('stocks.create') }}"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <x-icon name="plus" />
            Nouveau produit
        </a>
    </div>

    @include('partials.flash')

    <!-- Filtres -->
    <div class="flex flex-col sm:flex-row gap-4 mb-4">
        <div class="relative w-full sm:max-w-sm">
            <x-icon name="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
            <input type="text" id="searchInput" placeholder="Rechercher par nom de produit..."
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
                            Produit</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Fournisseur</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Quantité</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Prix achat</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Prix vente</th>
                        <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Actions</th>
                    </tr>
                </thead>
                <tbody id="stockList">
                    @forelse ($stocks as $stock)
                        @php
                            $stockBas = !is_null($stock->seuil_alerte) && !is_null($stock->quantite)
                                && $stock->quantite <= $stock->seuil_alerte;
                        @endphp
                        <tr class="group border-b border-slate-100 last:border-0 hover:bg-slate-50 stock-item"
                            data-name="{{ strtolower($stock->nom_produit) }}">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $stock->nom_produit }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $stock->fournisseur->nom ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($stockBas)
                                    <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-red-600">
                                        <x-icon name="triangle-alert" class="w-3.5 h-3.5" />
                                        {{ $stock->quantite }}
                                    </span>
                                    <x-badge color="red" class="ml-2">Stock bas</x-badge>
                                @else
                                    <span class="text-sm text-slate-700">{{ $stock->quantite ?? '—' }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                {{ !is_null($stock->prix_achat) ? number_format($stock->prix_achat, 2, ',', ' ') . ' €' : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                {{ !is_null($stock->prix_vente) ? number_format($stock->prix_vente, 2, ',', ' ') . ' €' : '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <div
                                    class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 focus-within:opacity-100 transition-opacity">
                                    <a href="{{ route('stocks.edit', $stock->id_produit) }}" title="Modifier"
                                        class="p-2 rounded-md text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                                        <x-icon name="pencil" />
                                    </a>
                                    <form action="{{ route('stocks.destroy', $stock->id_produit) }}" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ?')">
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
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500">
                                Aucun produit trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('resetFilters').addEventListener('click', resetFilters);

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const items = document.querySelectorAll('.stock-item');
            items.forEach((item) => {
                const name = item.getAttribute('data-name') || '';
                item.style.display = name.includes(searchTerm) ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            filterTable();
        }
    </script>
@endsection
