@extends('layouts.app')

@section('title', 'Mon profil — ERP')

@section('content')
    <!-- Header de page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center gap-1.5 text-sm text-slate-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-700 transition-colors">Accueil</a>
                <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                <span class="text-slate-700">Mon profil</span>
            </nav>
            <h1 class="text-xl font-semibold text-slate-900">Mon profil</h1>
        </div>
        <a href="{{ route('conges.create') }}"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <x-icon name="plus" />
            Faire une demande de congé
        </a>
    </div>

    @include('partials.flash')

    <!-- Informations personnelles -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
            <h2 class="text-sm font-semibold text-slate-900">Informations personnelles</h2>
            <a href="{{ route('user.edit', auth()->user()->id_utilisateur) }}"
                class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors">
                <x-icon name="pencil" class="w-3.5 h-3.5" />
                Éditer mon profil
            </a>
        </div>
        <dl class="px-6 divide-y divide-slate-100">
            <div class="flex items-center justify-between py-3">
                <dt class="text-sm font-medium text-slate-700">Nom d'utilisateur</dt>
                <dd class="text-sm text-slate-500">{{ auth()->user()->username }}</dd>
            </div>
            <div class="flex items-center justify-between py-3">
                <dt class="text-sm font-medium text-slate-700">Email</dt>
                <dd class="text-sm text-slate-500">{{ auth()->user()->email }}</dd>
            </div>
            <div class="flex items-center justify-between py-3">
                <dt class="text-sm font-medium text-slate-700">Date d'inscription</dt>
                <dd class="text-sm text-slate-500">{{ auth()->user()->date_creation->format('d/m/Y') }}</dd>
            </div>
        </dl>
    </div>

    <!-- Mes congés -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-4 border-b border-slate-200">
            <h2 class="text-sm font-semibold text-slate-900">Mes demandes de congé</h2>
            <input type="text" id="congeFilter" placeholder="Filtrer par type ou statut..."
                class="w-full sm:w-56 bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        </div>
        @if ($conges->isEmpty())
            <p class="px-6 py-8 text-center text-sm text-slate-500">Vous n'avez aucun congé pour le moment.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                                Date de début</th>
                            <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                                Date de fin</th>
                            <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                                Type</th>
                            <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                                Statut</th>
                        </tr>
                    </thead>
                    <tbody id="congeTableBody">
                        @foreach ($conges as $conge)
                            <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50">
                                <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $conge->type_conge }}</td>
                                <td class="px-6 py-4">
                                    @if (strtolower($conge->statut) === 'validé')
                                        <x-badge color="emerald">{{ $conge->statut }}</x-badge>
                                    @elseif (strtolower($conge->statut) === 'annulé')
                                        <x-badge color="red">{{ $conge->statut }}</x-badge>
                                    @elseif (strtolower($conge->statut) === 'en attente')
                                        <x-badge color="amber">{{ $conge->statut }}</x-badge>
                                    @else
                                        <x-badge color="slate">{{ $conge->statut }}</x-badge>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Mes salaires -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-4 border-b border-slate-200">
            <h2 class="text-sm font-semibold text-slate-900">Mes salaires</h2>
            <input type="text" id="salaireFilter" placeholder="Filtrer par date..."
                class="w-full sm:w-56 bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        </div>
        @if ($salaires->isEmpty())
            <p class="px-6 py-8 text-center text-sm text-slate-500">
                Vous n'avez aucun salaire enregistré pour le moment.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                                Montant</th>
                            <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                                Date de début</th>
                            <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                                Date de fin</th>
                        </tr>
                    </thead>
                    <tbody id="salaireTableBody">
                        @foreach ($salaires as $salaire)
                            <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 whitespace-nowrap">
                                    {{ number_format($salaire->montant, 2, ',', ' ') }}&nbsp;€
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($salaire->date_debut)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                    {{ $salaire->date_fin ? \Carbon\Carbon::parse($salaire->date_fin)->format('d/m/Y') : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script>
        // Filtrer les congés
        document.getElementById('congeFilter')?.addEventListener('input', function (e) {
            const filter = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#congeTableBody tr');

            rows.forEach(row => {
                const type = row.cells[2].textContent.toLowerCase();
                const statut = row.cells[3].textContent.toLowerCase();
                row.style.display = (type.includes(filter) || statut.includes(filter)) ? '' : 'none';
            });
        });

        // Filtrer les salaires
        document.getElementById('salaireFilter')?.addEventListener('input', function (e) {
            const filter = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#salaireTableBody tr');

            rows.forEach(row => {
                const dateDebut = row.cells[1].textContent.toLowerCase();
                const dateFin = row.cells[2].textContent.toLowerCase();
                row.style.display = (dateDebut.includes(filter) || dateFin.includes(filter)) ? '' : 'none';
            });
        });
    </script>
@endsection
