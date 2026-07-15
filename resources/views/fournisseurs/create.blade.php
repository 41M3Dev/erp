@extends('layouts.app')

@section('title', 'Nouveau fournisseur — ERP')

@section('content')
    @php
        $input = 'w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition';
        $label = 'block text-sm font-medium text-slate-700 mb-1.5';
    @endphp

    <div class="max-w-2xl mx-auto">
        <!-- Header de page -->
        <div class="mb-8">
            <a href="{{ route('fournisseurs.index') }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors mb-4">
                <x-icon name="arrow-left" />
                Retour aux fournisseurs
            </a>
            <h1 class="text-xl font-semibold text-slate-900">Nouveau fournisseur</h1>
        </div>

        @include('partials.flash')

        <!-- Formulaire -->
        <div class="bg-white rounded-lg border border-slate-200 p-8">
            <form action="{{ route('fournisseurs.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nom" class="{{ $label }}">Nom du fournisseur</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required
                            class="{{ $input }}">
                        @error('nom')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="contact" class="{{ $label }}">Nom du contact</label>
                        <input type="text" id="contact" name="contact" value="{{ old('contact') }}"
                            class="{{ $input }}">
                        @error('contact')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="email" class="{{ $label }}">Adresse email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="{{ $input }}">
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="telephone" class="{{ $label }}">Téléphone</label>
                        <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}"
                            class="{{ $input }}">
                        @error('telephone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="adresse" class="{{ $label }}">Adresse</label>
                    <textarea id="adresse" name="adresse" rows="2"
                        class="{{ $input }}">{{ old('adresse') }}</textarea>
                    @error('adresse')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="site_web" class="{{ $label }}">Site web</label>
                    <input type="text" id="site_web" name="site_web" value="{{ old('site_web') }}"
                        placeholder="https://…" class="{{ $input }}">
                    @error('site_web')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('fournisseurs.index') }}"
                        class="bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Enregistrer le fournisseur
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
