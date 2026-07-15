@extends('layouts.app')

@section('title', 'Modifier un salaire — ERP')

@section('content')
    @php
        $input = 'w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition';
        $label = 'block text-sm font-medium text-slate-700 mb-1.5';
    @endphp

    <div class="max-w-lg mx-auto">
        <!-- Header de page -->
        <div class="mb-8">
            <a href="{{ route('salaires.index') }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors mb-4">
                <x-icon name="arrow-left" />
                Retour aux salaires
            </a>
            <h1 class="text-xl font-semibold text-slate-900">Modifier le salaire</h1>
        </div>

        @include('partials.flash')

        <!-- Formulaire -->
        <div class="bg-white rounded-lg border border-slate-200 p-8">
            <form action="{{ route('salaires.update', $salaire->id_salaire) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="id_employe" class="{{ $label }}">Employé</label>
                    <select id="id_employe" name="id_employe" required class="{{ $input }}">
                        @foreach ($employes as $employe)
                            <option value="{{ $employe->id_employe }}"
                                {{ $salaire->id_employe == $employe->id_employe ? 'selected' : '' }}>
                                {{ $employe->nom }} {{ $employe->prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_employe')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="montant" class="{{ $label }}">Montant (€)</label>
                    <input type="number" step="0.01" id="montant" name="montant"
                        value="{{ old('montant', $salaire->montant) }}" required class="{{ $input }}">
                    @error('montant')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div>
                        <label for="date_debut" class="{{ $label }}">Date de début</label>
                        <input type="date" id="date_debut" name="date_debut"
                            value="{{ old('date_debut', optional($salaire->date_debut)->format('Y-m-d')) }}" required
                            class="{{ $input }}">
                        @error('date_debut')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="date_fin" class="{{ $label }}">Date de fin (optionnel)</label>
                        <input type="date" id="date_fin" name="date_fin"
                            value="{{ old('date_fin', optional($salaire->date_fin)->format('Y-m-d')) }}"
                            class="{{ $input }}">
                        @error('date_fin')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('salaires.index') }}"
                        class="bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Mettre à jour le salaire
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
