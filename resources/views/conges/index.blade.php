@extends('layouts.app')

@section('title', 'Congés — ERP')

@section('content')
    <!-- Header de page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center gap-1.5 text-sm text-slate-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-700 transition-colors">Accueil</a>
                <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                <span class="text-slate-700">Congés</span>
            </nav>
            <h1 class="text-xl font-semibold text-slate-900">Gestion des congés</h1>
        </div>
        <a href="{{ route('conges.create') }}"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <x-icon name="plus" />
            Nouveau congé
        </a>
    </div>

    @include('partials.flash')

    <!-- Filtres -->
    <div class="flex flex-col sm:flex-row gap-4 mb-4">
        <div class="relative w-full sm:max-w-xs">
            <x-icon name="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
            <input type="text" id="searchInput" placeholder="Rechercher par nom ou prénom..."
                class="w-full bg-white border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        </div>
        <select id="typeFilter"
            class="w-full sm:w-44 bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            <option value="">Tous les types</option>
            <option value="RTT">RTT</option>
            <option value="CP">CP</option>
            <option value="Maladie">Maladie</option>
        </select>
        <select id="statusFilter"
            class="w-full sm:w-44 bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            <option value="">Tous les statuts</option>
            <option value="En attente">En attente</option>
            <option value="Validé">Validé</option>
            <option value="Annulé">Annulé</option>
        </select>
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
                            Type</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Dates</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Commentaires</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Statut</th>
                        <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Actions</th>
                    </tr>
                </thead>
                <tbody id="leaveRequests">
                    @forelse ($conges as $conge)
                        <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50 request-item"
                            data-status="{{ $conge->statut }}" data-type="{{ $conge->type_conge }}"
                            data-name="{{ strtolower($conge->employe->nom ?? '') }} {{ strtolower($conge->employe->prenom ?? '') }}">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                {{ $conge->employe->nom ?? 'N/A' }} {{ $conge->employe->prenom ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $conge->type_conge }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m/Y') }}
                                &rarr;
                                {{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate"
                                title="{{ $conge->commentaires }}">
                                {{ $conge->commentaires ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($conge->statut === 'Validé')
                                    <x-badge color="emerald">Validé</x-badge>
                                @elseif ($conge->statut === 'Annulé')
                                    <x-badge color="red">Annulé</x-badge>
                                @else
                                    <x-badge color="amber">{{ $conge->statut }}</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($conge->statut === 'En attente')
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('conges.approve', $conge->id_conge) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium px-2.5 py-1.5 rounded-md transition-colors">
                                                <x-icon name="check" class="w-3.5 h-3.5" />
                                                Valider
                                            </button>
                                        </form>
                                        <form action="{{ route('conges.reject', $conge->id_conge) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-2.5 py-1.5 rounded-md transition-colors">
                                                <x-icon name="x" class="w-3.5 h-3.5" />
                                                Refuser
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <p class="text-right text-sm text-slate-400">Action terminée</p>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500">
                                Aucune demande de congé trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts de filtrage -->
    <script>
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);
        document.getElementById('typeFilter').addEventListener('change', filterTable);
        document.getElementById('resetFilters').addEventListener('click', resetFilters);

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const typeFilter = document.getElementById('typeFilter').value;
            const requests = document.getElementsByClassName('request-item');

            Array.from(requests).forEach(request => {
                const fullName = request.getAttribute('data-name');
                const status = request.getAttribute('data-status');
                const type = request.getAttribute('data-type');

                const matchesSearch = fullName.includes(searchTerm);
                const matchesStatus = !statusFilter || status === statusFilter;
                const matchesType = !typeFilter || type === typeFilter;

                request.style.display = (matchesSearch && matchesStatus && matchesType) ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('typeFilter').value = '';
            filterTable();
        }
    </script>
@endsection
