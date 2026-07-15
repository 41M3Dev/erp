@extends('layouts.app')

@section('title', 'Nouvel employé — ERP')

@section('content')
    @php
        $input = 'w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition';
        $label = 'block text-sm font-medium text-slate-700 mb-1.5';
        $derniersEmployes = \App\Models\Employe::orderByDesc('id_employe')->take(15)->get();
    @endphp

    <!-- Header de page -->
    <div class="mb-8">
        <a href="{{ route('employes.index') }}"
            class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors mb-4">
            <x-icon name="arrow-left" />
            Retour aux employés
        </a>
        <nav class="flex items-center gap-1.5 text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard') }}" class="hover:text-slate-700 transition-colors">Accueil</a>
            <x-icon name="chevron-right" class="w-3.5 h-3.5" />
            <a href="{{ route('employes.index') }}" class="hover:text-slate-700 transition-colors">Employés</a>
            <x-icon name="chevron-right" class="w-3.5 h-3.5" />
            <span class="text-slate-700">Nouvel employé</span>
        </nav>
        <h1 class="text-xl font-semibold text-slate-900">Nouvel employé</h1>
    </div>

    @include('partials.flash')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
        <!-- Formulaire -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 p-8">
            <form action="{{ route('employes.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nom" class="{{ $label }}">Nom</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required
                            class="{{ $input }}">
                        @error('nom')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="prenom" class="{{ $label }}">Prénom</label>
                        <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" required
                            class="{{ $input }}">
                        @error('prenom')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="{{ $label }}">Adresse email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="{{ $input }}">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="telephone" class="{{ $label }}">Téléphone</label>
                    <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}" required
                        class="{{ $input }}">
                    @error('telephone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="date_embauche" class="{{ $label }}">Date d'embauche</label>
                    <input type="date" id="date_embauche" name="date_embauche" value="{{ old('date_embauche') }}"
                        required class="{{ $input }}">
                    @error('date_embauche')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="departement" class="{{ $label }}">Département</label>
                    <select id="departement" name="departement" required class="{{ $input }}">
                        <option value="" disabled selected>Sélectionner un département</option>
                        <option value="rh" {{ old('departement') == 'rh' ? 'selected' : '' }}>RH</option>
                        <option value="finance" {{ old('departement') == 'finance' ? 'selected' : '' }}>Finance</option>
                        <option value="informatique" {{ old('departement') == 'informatique' ? 'selected' : '' }}>
                            Informatique</option>
                        <option value="livraison" {{ old('departement') == 'livraison' ? 'selected' : '' }}>Livraison
                        </option>
                        <option value="employe" {{ old('departement') == 'employe' ? 'selected' : '' }}>Employé</option>
                    </select>
                    @error('departement')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('employes.index') }}"
                        class="bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Derniers employés -->
        <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-sm font-semibold text-slate-900">15 derniers employés</h2>
            </div>
            <ul>
                @forelse ($derniersEmployes as $dernier)
                    <li class="flex items-center gap-3 px-6 py-3 border-b border-slate-100 last:border-0">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold shrink-0 uppercase">
                            {{ mb_substr($dernier->nom, 0, 1) }}{{ mb_substr($dernier->prenom, 0, 1) }}
                        </span>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-900 truncate">
                                {{ $dernier->nom }} {{ $dernier->prenom }}
                            </p>
                            <p class="text-xs text-slate-500 truncate capitalize">{{ $dernier->departement }}</p>
                        </div>
                    </li>
                @empty
                    <li class="px-6 py-8 text-center text-sm text-slate-500">Aucun employé.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <script>
        document.getElementById('nom').addEventListener('input', updateEmail);
        document.getElementById('prenom').addEventListener('input', updateEmail);

        function updateEmail() {
            const nom = document.getElementById('nom').value;
            const prenom = document.getElementById('prenom').value;
            const emailField = document.getElementById('email');
            if (nom && prenom) {
                const email = `${nom.toLowerCase()}.${prenom.toLowerCase()}@erp.com`;
                emailField.value = email;
            }
        }
    </script>
@endsection
