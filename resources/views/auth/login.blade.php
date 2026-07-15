<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — ERP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-indigo-600 text-white rounded-lg mb-4">
                    <x-icon name="layout-dashboard" class="w-6 h-6" />
                </div>
                <h1 class="text-xl font-bold text-indigo-600">ERP</h1>
                <p class="text-sm text-slate-500 mt-1">Connectez-vous pour continuer</p>
            </div>

            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 rounded-lg mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-slate-700 mb-1.5">Nom
                        d'utilisateur</label>
                    <input type="text" name="username" id="username" placeholder="Votre username" required autofocus
                        class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>
                <div class="mb-6">
                    <label for="mot_de_passe" class="block text-sm font-medium text-slate-700 mb-1.5">Mot de
                        passe</label>
                    <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="Votre mot de passe"
                        required
                        class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors cursor-pointer">
                    Se connecter
                </button>
            </form>

            <!-- Comptes de démonstration -->
            <div class="mt-8 bg-slate-50 rounded-lg p-4">
                <p class="text-center text-xs font-medium text-slate-500 uppercase tracking-wide mb-3">
                    Comptes de démonstration
                </p>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" onclick="remplir('superadmin', 'Password123!')"
                        class="bg-white hover:bg-slate-100 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors cursor-pointer">
                        Super Admin
                    </button>
                    <button type="button" onclick="remplir('admin', 'Password123!')"
                        class="bg-white hover:bg-slate-100 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors cursor-pointer">
                        Admin
                    </button>
                    <button type="button" onclick="remplir('manager.dubois', 'Password123!')"
                        class="bg-white hover:bg-slate-100 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors cursor-pointer">
                        Manager
                    </button>
                    <button type="button" onclick="remplir('employe.petit', 'Password123!')"
                        class="bg-white hover:bg-slate-100 text-slate-700 text-sm font-medium px-4 py-2 rounded-md border border-slate-200 transition-colors cursor-pointer">
                        Employé
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function remplir(username, password) {
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('mot_de_passe');
            usernameInput.setAttribute('value', username);
            passwordInput.setAttribute('value', password);
            usernameInput.value = username;
            passwordInput.value = password;
        }
    </script>
</body>

</html>
