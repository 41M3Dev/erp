@extends('layouts.app')

@section('title', 'Gestion des utilisateurs — ERP')

@section('content')
    @php
        $roleColors = [
            'superadmin' => 'purple',
            'admin' => 'indigo',
            'rh' => 'amber',
            'finance' => 'emerald',
            'manager' => 'blue',
            'livreur' => 'cyan',
            'employe' => 'slate',
        ];
    @endphp

    <!-- Header de page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center gap-1.5 text-sm text-slate-500 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-700 transition-colors">Accueil</a>
                <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                <span class="text-slate-700">Gestion utilisateurs</span>
            </nav>
            <h1 class="text-xl font-semibold text-slate-900">Gestion des utilisateurs</h1>
        </div>
        <a href="{{ route('admin.create') }}"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <x-icon name="plus" />
            Nouvel utilisateur
        </a>
    </div>

    @include('partials.flash')

    <!-- Filtres -->
    <div class="flex flex-col sm:flex-row gap-4 mb-4">
        <div class="relative w-full sm:max-w-sm">
            <x-icon name="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
            <input type="text" id="searchInput" placeholder="Rechercher par nom d'utilisateur..."
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
                            Username</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Email</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Rôles</th>
                        <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Date de création</th>
                        <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                            Actions</th>
                    </tr>
                </thead>
                <tbody id="utilisateursList">
                    @forelse ($utilisateurs as $utilisateur)
                        <tr class="group border-b border-slate-100 last:border-0 hover:bg-slate-50 utilisateur-item"
                            data-name="{{ strtolower($utilisateur->username) }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold shrink-0 uppercase">
                                        {{ mb_substr($utilisateur->username, 0, 1) }}
                                    </span>
                                    <span class="text-sm font-medium text-slate-900">{{ $utilisateur->username }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $utilisateur->email ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse ($utilisateur->roles as $role)
                                        <x-badge :color="$roleColors[strtolower($role->nom_role)] ?? 'slate'"
                                            class="capitalize">
                                            {{ $role->nom_role }}
                                        </x-badge>
                                    @empty
                                        <span class="text-sm text-slate-400">—</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap">
                                {{ $utilisateur->date_creation ? \Carbon\Carbon::parse($utilisateur->date_creation)->format('d/m/Y') : '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <div
                                    class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 focus-within:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.edit', $utilisateur->id_utilisateur) }}" title="Modifier"
                                        class="p-2 rounded-md text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                                        <x-icon name="pencil" />
                                    </a>
                                    <form action="{{ route('admin.destroy', $utilisateur->id_utilisateur) }}"
                                        method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?')">
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
                                Aucun utilisateur trouvé.
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
            const utilisateurs = document.querySelectorAll('.utilisateur-item');
            utilisateurs.forEach((utilisateur) => {
                const name = utilisateur.getAttribute('data-name') || '';
                utilisateur.style.display = name.includes(searchTerm) ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            filterTable();
        }
    </script>
@endsection
