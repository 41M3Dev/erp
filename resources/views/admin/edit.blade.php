@extends('layouts.app')

@section('title', 'Modifier un utilisateur — ERP')

@section('content')
    @php
        $input = 'w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition';
        $label = 'block text-sm font-medium text-slate-700 mb-1.5';
    @endphp

    <div class="max-w-2xl mx-auto">
        <!-- Header de page -->
        <div class="mb-8">
            <a href="{{ route('admin.index') }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors mb-4">
                <x-icon name="arrow-left" />
                Retour à la liste
            </a>
            <h1 class="text-xl font-semibold text-slate-900">
                Modifier l'utilisateur : {{ $utilisateur->username }}
            </h1>
        </div>

        @include('partials.flash')

        <!-- Formulaire -->
        <div class="bg-white rounded-lg border border-slate-200 p-8">
            <form action="{{ route('admin.update', $utilisateur->id_utilisateur) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="username" class="{{ $label }}">Nom d'utilisateur</label>
                    <input type="text" name="username" id="username"
                        value="{{ old('username', $utilisateur->username) }}" class="{{ $input }}">
                    @error('username')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="{{ $label }}">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $utilisateur->email) }}"
                        class="{{ $input }}">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
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
                    <div>
                        <label for="password_confirmation" class="{{ $label }}">
                            Confirmer le mot de passe
                            <span class="block text-xs font-normal text-slate-500">&nbsp;</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="{{ $input }}">
                    </div>
                </div>

                <div class="mb-8">
                    <p class="{{ $label }}">Rôles</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($roles as $role)
                            <label for="role{{ $role->id_role }}"
                                class="inline-flex items-center gap-2 bg-white border border-slate-200 rounded-md px-3 py-2 text-sm text-slate-700 cursor-pointer hover:bg-slate-50 has-checked:bg-indigo-50 has-checked:border-indigo-200 has-checked:text-indigo-700 transition-colors">
                                <input type="checkbox" name="roles[]" id="role{{ $role->id_role }}"
                                    value="{{ $role->id_role }}"
                                    {{ $utilisateur->roles->contains($role->id_role) ? 'checked' : '' }}
                                    class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="capitalize">{{ $role->nom_role }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('roles')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.index') }}"
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
