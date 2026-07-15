@extends('layouts.app')

@section('title', 'Tableau de bord — ERP')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <!-- Header de page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center gap-1.5 text-sm text-slate-500 mb-1">
                <span>Accueil</span>
                <x-icon name="chevron-right" class="w-3.5 h-3.5" />
                <span class="text-slate-700">Tableau de bord</span>
            </nav>
            <h1 class="text-xl font-semibold text-slate-900">Tableau de bord</h1>
        </div>
        <div class="flex items-center gap-3 text-sm text-slate-500">
            <span class="first-letter:uppercase font-medium text-slate-700">{{ Auth::user()->username ?? 'User' }}</span>
        </div>
    </div>

    @include('partials.flash')

    @php
        $canSeeFinance = Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance']);
        $canSeeStock = Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance', 'manager', 'livreur']);
        $canSeeRh = Auth::user()->hasAnyRole(['superadmin', 'admin', 'rh']);
        $commandesEnCours = $canSeeStock ? \App\Models\Commande::where('statut_livraison', 'En cours')->count() : null;
        $congesEnAttente = $canSeeRh
            ? \App\Models\Conge::with('employe')->where('statut', 'En attente')->orderByDesc('id_conge')->take(5)->get()
            : collect();
    @endphp

    <!-- Cards KPI -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center gap-4">
                <span class="bg-indigo-50 text-indigo-600 rounded-md p-2">
                    <x-icon name="users" class="w-5 h-5" />
                </span>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{ $activeEmployeesCount }}</p>
                    <p class="text-sm text-slate-500">Employés actifs</p>
                </div>
            </div>
        </div>

        @if ($financeStats)
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <span class="bg-indigo-50 text-indigo-600 rounded-md p-2">
                        <x-icon name="trending-up" class="w-5 h-5" />
                    </span>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">
                            {{ number_format($financeStats->revenus ?? 0, 0, ',', ' ') }}&nbsp;€
                        </p>
                        <p class="text-sm text-slate-500">Revenus totaux</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <span class="bg-indigo-50 text-indigo-600 rounded-md p-2">
                        <x-icon name="trending-down" class="w-5 h-5" />
                    </span>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">
                            {{ number_format($financeStats->depenses ?? 0, 0, ',', ' ') }}&nbsp;€
                        </p>
                        <p class="text-sm text-slate-500">Dépenses totales</p>
                    </div>
                </div>
            </div>
        @endif

        @if (!is_null($commandesEnCours))
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-4">
                    <span class="bg-indigo-50 text-indigo-600 rounded-md p-2">
                        <x-icon name="shopping-cart" class="w-5 h-5" />
                    </span>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $commandesEnCours }}</p>
                        <p class="text-sm text-slate-500">Commandes en cours</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Graphiques -->
    @if ($canSeeFinance || $canSeeStock)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
            @if ($canSeeFinance)
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <h2 class="text-sm font-semibold text-slate-900 mb-4">Répartition des finances</h2>
                    <div class="max-w-xs mx-auto">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>
            @endif

            @if ($canSeeStock)
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <h2 class="text-sm font-semibold text-slate-900 mb-4">Stock des produits</h2>
                    <canvas id="stockChart"></canvas>
                </div>
            @endif
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @if ($canSeeRh)
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-slate-900">Employés par département</h2>
                    <a href="{{ route('employes.index') }}"
                        class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Voir tout</a>
                </div>
                <canvas id="employeeDeptChart"></canvas>
            </div>

            <!-- Derniers congés en attente -->
            <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                    <h2 class="text-sm font-semibold text-slate-900">Derniers congés en attente</h2>
                    <a href="{{ route('conges.index') }}"
                        class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Voir tout</a>
                </div>
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                                Employé</th>
                            <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                                Type</th>
                            <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                                Dates</th>
                            <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-6 py-3">
                                Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($congesEnAttente as $conge)
                            <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50">
                                <td class="px-6 py-4 text-sm text-slate-700 font-medium">
                                    {{ $conge->employe->nom ?? 'N/A' }} {{ $conge->employe->prenom ?? '' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ $conge->type_conge }}</td>
                                <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m/Y') }}
                                    &rarr;
                                    {{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <x-badge color="amber">En attente</x-badge>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-slate-500">
                                    Aucun congé en attente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script>
        // Configuration globale de Chart.js
        Chart.defaults.font.size = 12;
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#64748B';

        @if ($canSeeFinance)
            // ---------------------------
            // Finances (Pie Chart)
            const financeData = @json($financeStats);
            new Chart(document.getElementById('financeChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Revenus', 'Dépenses', 'Factures'],
                    datasets: [{
                        data: [financeData.revenus, financeData.depenses, financeData.factures],
                        backgroundColor: ['#4F46E5', '#EF4444', '#F59E0B'],
                        borderColor: '#FFFFFF',
                        borderWidth: 2
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12 }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.label || '';
                                    if (label) label += ': ';
                                    label += new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(context.parsed);
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        @endif

        @if ($canSeeStock)
            // ---------------------------
            // Stock (Bar Chart horizontal)
            const stockData = @json($stockStats);
            const stockLabels = stockData.map(s => s.nom_produit);
            const stockValues = stockData.map(s => s.quantite);
            new Chart(document.getElementById('stockChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: stockLabels,
                    datasets: [{
                        label: 'Quantité en stock',
                        data: stockValues,
                        backgroundColor: '#818CF8',
                        borderColor: '#4F46E5',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        x: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#F1F5F9' } },
                        y: { grid: { display: false } }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.label}: ${context.parsed.x} unités`;
                                }
                            }
                        }
                    }
                }
            });
        @endif

        @if ($canSeeRh)
            // ---------------------------
            // Employés par Département (actifs) - Bar Chart horizontal
            const employeeDeptData = @json($employeeDeptStats);
            const deptLabels = employeeDeptData.map(e => e.departement);
            const deptCounts = employeeDeptData.map(e => e.total);
            new Chart(document.getElementById('employeeDeptChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: deptLabels,
                    datasets: [{
                        label: 'Employés par département',
                        data: deptCounts,
                        backgroundColor: '#4F46E5',
                        borderRadius: 4
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        x: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#F1F5F9' } },
                        y: { grid: { display: false } }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        @endif
    </script>
@endsection
