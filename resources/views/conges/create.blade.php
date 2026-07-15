@extends('layouts.app')

@section('title', 'Demande de congé — ERP')

@section('content')
    @php
        $input = 'w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition';
        $label = 'block text-sm font-medium text-slate-700 mb-1.5';
        $retour = Auth::user()->hasRole('superadmin') ? route('conges.index') : route('user.dashboard');
    @endphp

    <div class="max-w-lg mx-auto">
        <!-- Header de page -->
        <div class="mb-8">
            <a href="{{ $retour }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors mb-4">
                <x-icon name="arrow-left" />
                Retour
            </a>
            <h1 class="text-xl font-semibold text-slate-900">Nouvelle demande de congé</h1>
            <p class="text-sm text-slate-500 mt-1">Renseignez les informations de votre demande.</p>
        </div>

        @include('partials.flash')

        <!-- Formulaire -->
        <div class="bg-white rounded-lg border border-slate-200 p-8">
            <form action="{{ route('conges.create.store') }}" method="POST">
                @csrf

                <!-- ID utilisateur caché -->
                <input type="hidden" name="user_id" value="{{ Auth::user()->id_employe }}">

                <div class="mb-4">
                    <label for="type_conge" class="{{ $label }}">Type de congé</label>
                    <select id="type_conge" name="type_conge" required class="{{ $input }}">
                        <option value="">Sélectionnez un type</option>
                        <option value="RTT" {{ old('type_conge') == 'RTT' ? 'selected' : '' }}>RTT</option>
                        <option value="CP" {{ old('type_conge') == 'CP' ? 'selected' : '' }}>Congés Payés (CP)</option>
                        <option value="Maladie" {{ old('type_conge') == 'Maladie' ? 'selected' : '' }}>Maladie</option>
                    </select>
                    @error('type_conge')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="date_debut" class="{{ $label }}">Date de début</label>
                        <input type="date" id="date_debut" name="date_debut" value="{{ old('date_debut') }}" required
                            class="{{ $input }}">
                        @error('date_debut')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="date_fin" class="{{ $label }}">Date de fin</label>
                        <input type="date" id="date_fin" name="date_fin" value="{{ old('date_fin') }}" required
                            class="{{ $input }}">
                        @error('date_fin')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-8">
                    <label for="raison" class="{{ $label }}">Raison</label>
                    <textarea id="raison" name="raison" rows="3" placeholder="Expliquez la raison de votre demande"
                        class="{{ $input }}">{{ old('raison') }}</textarea>
                    @error('raison')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ $retour }}"
                        class="bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" id="submitButton"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Soumettre la demande
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const typeCongeSelect = document.getElementById('type_conge');
        const submitButton = document.getElementById('submitButton');

        typeCongeSelect.addEventListener('change', function () {
            submitButton.textContent = this.value === 'Maladie'
                ? 'Envoyer le congé'
                : 'Soumettre la demande';
        });
    </script>
@endsection
