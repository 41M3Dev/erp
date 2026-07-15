@extends('layouts.app')

@section('title', 'Nouvelle entrée financière — ERP')

@section('content')
    @php
        $input = 'w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition';
        $label = 'block text-sm font-medium text-slate-700 mb-1.5';
    @endphp

    <div class="max-w-2xl mx-auto">
        <!-- Header de page -->
        <div class="mb-8">
            <a href="{{ route('finances.index') }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors mb-4">
                <x-icon name="arrow-left" />
                Retour aux finances
            </a>
            <h1 class="text-xl font-semibold text-slate-900">Nouvelle entrée financière</h1>
        </div>

        @include('partials.flash')

        <!-- Formulaire -->
        <div class="bg-white rounded-lg border border-slate-200 p-8">
            <form action="{{ route('finances.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="type_operation" class="{{ $label }}">Type d'opération</label>
                        <select id="type_operation" name="type_operation" required class="{{ $input }}">
                            <option value="">-- Sélectionnez un type --</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" {{ old('type_operation') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        @error('type_operation')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="categorie" class="{{ $label }}">Catégorie</label>
                        <select id="categorie" name="categorie" required class="{{ $input }}">
                            <option value="">-- Sélectionnez une catégorie --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ old('categorie') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        @error('categorie')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="{{ $label }}">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="{{ $input }}">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="montant" class="{{ $label }}">Montant (€)</label>
                        <input type="number" step="0.01" id="montant" name="montant" value="{{ old('montant') }}"
                            required class="{{ $input }}">
                        @error('montant')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="date_operation" class="{{ $label }}">Date d'opération</label>
                        <input type="date" id="date_operation" name="date_operation" value="{{ old('date_operation') }}"
                            required class="{{ $input }}">
                        @error('date_operation')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="id_fournisseur" class="{{ $label }}">Fournisseur (optionnel)</label>
                    <select id="id_fournisseur" name="id_fournisseur" class="{{ $input }}">
                        <option value="">-- Aucun --</option>
                        @foreach ($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id_fournisseur }}"
                                {{ old('id_fournisseur') == $fournisseur->id_fournisseur ? 'selected' : '' }}>
                                {{ $fournisseur->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_fournisseur')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div>
                        <label for="statut" class="{{ $label }}">Statut</label>
                        <select id="statut" name="statut" required class="{{ $input }}">
                            <option value="">-- Sélectionnez un statut --</option>
                            @foreach ($statuts as $stat)
                                <option value="{{ $stat }}" {{ old('statut') == $stat ? 'selected' : '' }}>
                                    {{ $stat }}
                                </option>
                            @endforeach
                        </select>
                        @error('statut')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="reference_facture" class="{{ $label }}">Réf. facture (optionnel)</label>
                        <input type="text" id="reference_facture" name="reference_facture"
                            value="{{ old('reference_facture') }}" class="{{ $input }}">
                        @error('reference_facture')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('finances.index') }}"
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
    </div>
@endsection
