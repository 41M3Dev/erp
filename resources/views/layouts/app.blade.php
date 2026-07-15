<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ERP')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>

<body class="bg-slate-50 text-slate-900 antialiased">

    @php
        $navItem = fn(bool $active) => $active
            ? 'flex items-center gap-3 py-2 px-3 rounded-md bg-indigo-50 text-indigo-600 font-medium'
            : 'flex items-center gap-3 py-2 px-3 rounded-md text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors';
        $groupLabel = 'text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-1 mt-6';
    @endphp

    <!-- Bouton menu mobile -->
    <button id="burger-btn" type="button" aria-label="Ouvrir le menu"
        class="lg:hidden fixed top-4 right-4 z-50 p-2 bg-white border border-slate-200 rounded-md text-slate-600 hover:bg-slate-50 transition-colors">
        <x-icon name="menu" class="w-5 h-5" />
    </button>
    <div id="sidebar-overlay" class="lg:hidden fixed inset-0 bg-slate-900/40 z-30 hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-40 w-60 h-screen bg-white border-r border-slate-200 flex flex-col -translate-x-full lg:translate-x-0 transition-transform duration-200">
        <!-- Logo -->
        <div class="p-6">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-indigo-600 font-bold text-lg">
                <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-md">
                    <x-icon name="layout-dashboard" class="w-4 h-4" />
                </span>
                ERP
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-3 pb-4 text-sm">
            <p class="{{ $groupLabel }} mt-0">Général</p>
            <a href="{{ route('dashboard') }}" class="{{ $navItem(request()->routeIs('dashboard')) }}">
                <x-icon name="layout-dashboard" />
                Dashboard
            </a>
            <a href="{{ route('user.dashboard') }}"
                class="{{ $navItem(request()->routeIs('user.dashboard') || request()->routeIs('user.edit')) }} mt-1">
                <x-icon name="user" />
                Mon profil
            </a>

            @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'rh', 'finance']))
                <p class="{{ $groupLabel }}">RH</p>
                @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'rh']))
                    <a href="{{ route('employes.index') }}" class="{{ $navItem(request()->routeIs('employes.*')) }}">
                        <x-icon name="users" />
                        Employés
                    </a>
                    <a href="{{ route('conges.index') }}"
                        class="{{ $navItem(request()->routeIs('conges.*')) }} mt-1">
                        <x-icon name="calendar-days" />
                        Congés
                    </a>
                @endif
                @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance', 'rh']))
                    <a href="{{ route('salaires.index') }}"
                        class="{{ $navItem(request()->routeIs('salaires.*')) }} mt-1">
                        <x-icon name="banknote" />
                        Salaires
                    </a>
                @endif
            @endif

            @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance']))
                <p class="{{ $groupLabel }}">Finance</p>
                <a href="{{ route('finances.index') }}" class="{{ $navItem(request()->routeIs('finances.*')) }}">
                    <x-icon name="wallet" />
                    Finances
                </a>
            @endif

            @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance', 'livreur', 'manager']))
                <p class="{{ $groupLabel }}">Logistique</p>
                <a href="{{ route('stocks.index') }}" class="{{ $navItem(request()->routeIs('stocks.*')) }}">
                    <x-icon name="package" />
                    Stocks
                </a>
                <a href="{{ route('fournisseurs.index') }}"
                    class="{{ $navItem(request()->routeIs('fournisseurs.*')) }} mt-1">
                    <x-icon name="building" />
                    Fournisseurs
                </a>
                <a href="{{ route('commandes.index') }}"
                    class="{{ $navItem(request()->routeIs('commandes.*')) }} mt-1">
                    <x-icon name="shopping-cart" />
                    Commandes
                </a>
            @endif

            @if (Auth::user()->hasAnyRole(['superadmin', 'admin']))
                <p class="{{ $groupLabel }}">Admin</p>
                <a href="{{ route('admin.index') }}" class="{{ $navItem(request()->routeIs('admin.*')) }}">
                    <x-icon name="shield" />
                    Gestion utilisateurs
                </a>
            @endif
        </nav>

        <!-- Bloc utilisateur connecté -->
        <div class="border-t border-slate-200 p-4">
            @php
                $roles = Auth::user()->roles;
                $filteredRoles = $roles->reject(fn($role) => $role->nom_role === 'employe');
                if ($filteredRoles->isEmpty()) {
                    $filteredRoles = $roles;
                }
            @endphp
            <div class="flex items-center gap-3">
                <span
                    class="flex items-center justify-center w-9 h-9 rounded-full bg-indigo-50 text-indigo-600 text-sm font-semibold shrink-0 uppercase">
                    {{ mb_substr(Auth::user()->username ?? 'U', 0, 1) }}
                </span>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-900 truncate first-letter:uppercase">
                        {{ Auth::user()->username ?? 'Utilisateur' }}
                    </p>
                    <p class="text-xs text-slate-500 truncate first-letter:uppercase">
                        {{ $filteredRoles->pluck('nom_role')->join(', ') }}
                    </p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Se déconnecter"
                        class="p-2 rounded-md text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                        <x-icon name="log-out" />
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Zone contenu -->
    <div class="lg:pl-60">
        <main class="min-h-screen p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    <!-- Notification démo -->
    <div id="notif"
        class="fixed bottom-6 right-6 bg-white border border-slate-200 shadow-sm rounded-lg px-4 py-3 text-sm text-slate-600 max-w-xs z-50"
        style="display: none;">
        <div class="flex items-start gap-3">
            <x-icon name="info" class="w-4 h-4 mt-0.5 text-indigo-600 shrink-0" />
            <p>
                Faites toutes les modifications que vous souhaitez,
                les données sont réinitialisées toutes les 12h (midi et minuit).
            </p>
            <button id="close-notif" type="button" aria-label="Fermer"
                class="text-slate-400 hover:text-slate-600 shrink-0">
                <x-icon name="x" />
            </button>
        </div>
    </div>

    <script>
        const burgerBtn = document.getElementById('burger-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        burgerBtn?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        if (!sessionStorage.getItem('notifClosed')) {
            document.getElementById('notif').style.display = 'block';
        }

        document.getElementById('close-notif')?.addEventListener('click', () => {
            document.getElementById('notif')?.remove();
            sessionStorage.setItem('notifClosed', 'true');
        });
    </script>

</body>

</html>
