@extends('layouts.app')

@section('title', 'Modifier mon profil — ERP')

@section('content')
    @php
        $input = 'w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition';
        $label = 'block text-sm font-medium text-slate-700 mb-1.5';
    @endphp

    <div class="max-w-lg mx-auto">
        <!-- Header de page -->
        <div class="mb-8">
            <a href="{{ route('user.dashboard') }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors mb-4">
                <x-icon name="arrow-left" />
                Retour à mon profil
            </a>
            <h1 class="text-xl font-semibold text-slate-900">
                Modifier mon profil : {{ $user->username }}
            </h1>
        </div>

        @include('partials.flash')

        <!-- Formulaire -->
        <div class="bg-white rounded-lg border border-slate-200 p-8">
            <form action="{{ route('user.update', $user->id_utilisateur) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="username" class="{{ $label }}">Nom d'utilisateur</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                        class="{{ $input }}">
                    @error('username')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="{{ $label }}">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="{{ $input }}">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="{{ $label }}">
                        Nouveau mot de passe
                        <span class="block text-xs font-normal text-slate-500">Laisser vide pour conserver
                            l'ancien</span>
                    </label>
                    <input type="password" name="password" id="password" class="{{ $input }}">
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="password_confirmation" class="{{ $label }}">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="{{ $input }}">
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('user.dashboard') }}"
                        class="bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
