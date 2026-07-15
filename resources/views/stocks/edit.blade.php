@extends('layouts.app')

@section('title', 'Modifier un produit — ERP')

@section('content')
    @php
        $input = 'w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition';
        $label = 'block text-sm font-medium text-slate-700 mb-1.5';
    @endphp

    <div class="max-w-2xl mx-auto">
        <!-- Header de page -->
        <div class="mb-8">
            <a href="{{ route('stocks.index') }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors mb-4">
                <x-icon name="arrow-left" />
                Retour aux stocks
            </a>
            <h1 class="text-xl font-semibold text-slate-900">Modifier le produit : {{ $stock->nom_produit }}</h1>
        </div>

        @include('partials.flash')

        <!-- Formulaire -->
        <div class="bg-white rounded-lg border border-slate-200 p-8">
            <form action="{{ route('stocks.update', $stock->id_produit) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nom_produit" class="{{ $label }}">Nom du produit</label>
                    <input type="text" id="nom_produit" name="nom_produit"
                        value="{{ old('nom_produit', $stock->nom_produit) }}" required class="{{ $input }}">
                    @error('nom_produit')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="id_fournisseur" class="{{ $label }}">Fournisseur</label>
                    <select id="id_fournisseur" name="id_fournisseur" class="{{ $input }}">
                        <option value="">-- Sélectionnez un fournisseur --</option>
                        @foreach ($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id_fournisseur }}"
                                {{ old('id_fournisseur', $stock->id_fournisseur) == $fournisseur->id_fournisseur ? 'selected' : '' }}>
                                {{ $fournisseur->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_fournisseur')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="{{ $label }}">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="{{ $input }}">{{ old('description', $stock->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="quantite" class="{{ $label }}">Quantité</label>
                        <input type="number" id="quantite" name="quantite"
                            value="{{ old('quantite', $stock->quantite) }}" required class="{{ $input }}">
                        @error('quantite')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="seuil_alerte" class="{{ $label }}">Seuil d'alerte</label>
                        <input type="number" id="seuil_alerte" name="seuil_alerte"
                            value="{{ old('seuil_alerte', $stock->seuil_alerte) }}" class="{{ $input }}">
                        @error('seuil_alerte')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div>
                        <label for="prix_achat" class="{{ $label }}">Prix d'achat (€)</label>
                        <input type="number" step="0.01" id="prix_achat" name="prix_achat"
                            value="{{ old('prix_achat', $stock->prix_achat) }}" class="{{ $input }}">
                        @error('prix_achat')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="prix_vente" class="{{ $label }}">Prix de vente (€)</label>
                        <input type="number" step="0.01" id="prix_vente" name="prix_vente"
                            value="{{ old('prix_vente', $stock->prix_vente) }}" class="{{ $input }}">
                        @error('prix_vente')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('stocks.index') }}"
                        class="bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Mettre à jour le produit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
