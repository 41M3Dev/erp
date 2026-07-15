@extends('layouts.app')

@section('title', 'Modifier une commande — ERP')

@section('content')
    @php
        $input = 'w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition';
        $label = 'block text-sm font-medium text-slate-700 mb-1.5';
    @endphp

    <div class="max-w-2xl mx-auto">
        <!-- Header de page -->
        <div class="mb-8">
            <a href="{{ route('commandes.index') }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors mb-4">
                <x-icon name="arrow-left" />
                Retour aux commandes
            </a>
            <h1 class="text-xl font-semibold text-slate-900">
                Modifier la commande : {{ $commande->reference_commande }}
            </h1>
        </div>

        @include('partials.flash')

        <!-- Formulaire -->
        <div class="bg-white rounded-lg border border-slate-200 p-8">
            <form action="{{ route('commandes.update', $commande->id_livraison) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="reference_commande" class="{{ $label }}">Référence de la commande</label>
                    <input type="text" id="reference_commande" name="reference_commande"
                        value="{{ old('reference_commande', $commande->reference_commande) }}" required
                        class="{{ $input }}">
                    @error('reference_commande')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="id_fournisseur" class="{{ $label }}">Fournisseur</label>
                    <select id="id_fournisseur" name="id_fournisseur" class="{{ $input }}">
                        <option value="">-- Aucun --</option>
                        @foreach ($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id_fournisseur }}"
                                {{ old('id_fournisseur', $commande->id_fournisseur) == $fournisseur->id_fournisseur ? 'selected' : '' }}>
                                {{ $fournisseur->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_fournisseur')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="destinataire" class="{{ $label }}">Destinataire</label>
                    <input type="text" id="destinataire" name="destinataire"
                        value="{{ old('destinataire', $commande->destinataire) }}" class="{{ $input }}">
                    @error('destinataire')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div>
                        <label for="date_livraison" class="{{ $label }}">Date de livraison</label>
                        <input type="date" id="date_livraison" name="date_livraison"
                            value="{{ old('date_livraison', $commande->date_livraison ? \Carbon\Carbon::parse($commande->date_livraison)->format('Y-m-d') : date('Y-m-d')) }}"
                            class="{{ $input }}">
                        @error('date_livraison')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="statut_livraison" class="{{ $label }}">Statut de la livraison</label>
                        <select id="statut_livraison" name="statut_livraison" required class="{{ $input }}">
                            <option value="">-- Sélectionnez un statut --</option>
                            @foreach ($statuts as $statut)
                                <option value="{{ $statut }}"
                                    {{ old('statut_livraison', $commande->statut_livraison) == $statut ? 'selected' : '' }}>
                                    {{ $statut }}
                                </option>
                            @endforeach
                        </select>
                        @error('statut_livraison')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('commandes.index') }}"
                        class="bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Mettre à jour la commande
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
