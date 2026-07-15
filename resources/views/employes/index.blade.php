@extends('layouts.app')

@section('title', 'Employés — ERP')

@section('content')
    <!-- Header de page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center gap-1.5 text-sm text-slate-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-700 transition-colors">Accueil</a>
                <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                <span class="text-slate-700">Employés</span>
            </nav>
            <h1 class="text-xl font-semibold text-slate-900">Employés</h1>
        </div>
        <a href="{{ route('employes.create') }}"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <x-icon name="plus" />
            Ajouter un employé
        </a>
    </div>

    @include('partials.flash')

    <!-- Filtres -->
    <div class="flex flex-col sm:flex-row gap-4 mb-4">
        <div class="relative w-full sm:max-w-sm">
            <x-icon name="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
            <input type="text" id="searchInput" placeholder="Rechercher par nom, prénom, email, département..."
                class="w-full bg-white border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        </div>
        <select id="activeFilter"
            class="w-full sm:w-44 bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            <option value="all">Tous les statuts</option>
            <option value="yes">Actif : Oui</option>
            <option value="no">Actif : Non</option>
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Nom / Prénom</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Email</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Département</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Date d'embauche</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Statut</th>
                        <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Actions</th>
                    </tr>
                </thead>
                <tbody id="employeeList">
                    @forelse ($employes as $employe)
                        @php
                            $deptColors = [
                                'rh' => 'purple',
                                'finance' => 'emerald',
                                'informatique' => 'blue',
                                'livraison' => 'amber',
                                'employe' => 'slate',
                            ];
                            $deptColor = $deptColors[strtolower($employe->departement)] ?? 'slate';
                        @endphp
                        <tr class="group border-b border-slate-100 last:border-0 hover:bg-slate-50 employee-item"
                            data-nom="{{ strtolower($employe->nom) }}" data-prenom="{{ strtolower($employe->prenom) }}"
                            data-email="{{ strtolower($employe->email) }}"
                            data-departement="{{ strtolower($employe->departement) }}"
                            data-actif="{{ $employe->actif ? 'yes' : 'no' }}">
                            <td class="px-6 py-4 text-sm text-slate-700">
                                <span class="font-medium text-slate-900">{{ $employe->nom }}</span>
                                {{ $employe->prenom }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $employe->email }}</td>
                            <td class="px-6 py-4">
                                <x-badge :color="$deptColor" class="capitalize">{{ $employe->departement }}</x-badge>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($employe->date_embauche)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($employe->actif)
                                    <x-badge color="emerald">Actif</x-badge>
                                @else
                                    <x-badge color="red">Inactif</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div
                                    class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 focus-within:opacity-100 transition-opacity">
                                    <a href="{{ route('employes.edit', $employe->id_employe) }}" title="Modifier"
                                        class="p-2 rounded-md text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                                        <x-icon name="pencil" />
                                    </a>
                                    <form action="{{ route('employes.destroy', $employe->id_employe) }}" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer cet employé ?')">
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
                                Aucun employé trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterEmployees() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const activeFilter = document.getElementById('activeFilter').value;
            const employees = document.querySelectorAll('.employee-item');

            employees.forEach(employee => {
                const nom = employee.getAttribute('data-nom');
                const prenom = employee.getAttribute('data-prenom');
                const email = employee.getAttribute('data-email');
                const departement = employee.getAttribute('data-departement');
                const actif = employee.getAttribute('data-actif');

                const matchesSearch = nom.includes(searchTerm) || prenom.includes(searchTerm) || email.includes(searchTerm) || departement.includes(searchTerm);
                const matchesActive = activeFilter === 'all' || actif === activeFilter;

                employee.style.display = (matchesSearch && matchesActive) ? '' : 'none';
            });
        }

        document.getElementById('searchInput').addEventListener('input', filterEmployees);
        document.getElementById('activeFilter').addEventListener('change', filterEmployees);
    </script>
@endsection
