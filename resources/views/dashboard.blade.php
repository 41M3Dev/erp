@extends('layouts.app')

@section('content')
    <main class="main-content flex-1 ml-64 p-6">
        <header class="bg-white shadow p-4 rounded-lg mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold">Tableau de Bord</h2>
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <i class="fas fa-user-circle text-2xl mr-2"></i>
                    <div>
                        <span class="first-letter:uppercase">{{ Auth::user()->username ?? 'User' }}</span>
                        @php
                            $roles = Auth::user()->roles;
                            $filteredRoles = $roles->reject(function ($role) {
                                return $role->nom_role === 'employe';
                            });
                            if ($filteredRoles->isEmpty()) {
                                $filteredRoles = $roles;
                            }
                        @endphp
                        <div class="text-xs text-gray-500 firt-letter:uppercase">
                            {{ $filteredRoles->pluck('nom_role')->join(', ') }}
                        </div>
                    </div>
                </div>
            </div>
        </header>


        @if (session('error'))
            <div class="flex items-center gap-3 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow mb-4">
                <i class="fas fa-exclamation-triangle text-xl"></i>
                <span class="text-base">{{ session('error') }}</span>
            </div>
        @endif
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow mb-4">
                <i class="fas fa-check-circle text-xl"></i>
                <span class="text-base">{{ session('success') }}</span>
            </div>
        @endif


        @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance']) || Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance', 'manager', 'livreur']))
        <!-- Dashboard Content: deux colonnes sur grand écran -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance']))
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-medium">Finances</h3>
                </div>
                <canvas id="financeChart" height="40"></canvas>
            </div>
            @endif

            @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance', 'manager', 'livreur']))
            <!-- Card: Stock (réduite) -->
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Stock des Produits</h3>
                </div>
                <canvas id="stockChart" height="100"></canvas>
            </div>
            @endif
        </div>
        @endif

        <!-- Nouvelle ligne: Employés par Département + Nombre d'employés actifs -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'rh']))
            <!-- Card: Employés par Département (actifs uniquement) -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Employés par Département</h3>
                    <a href="{{ route('employes.index') }}" class="text-blue-600 hover:underline text-sm">Voir plus</a>
                </div>
                <canvas id="employeeDeptChart" height="150"></canvas>
            </div>
            @endif

            <!-- Card: Nombre d'Employés Actifs -->
            <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center justify-center">
                <h3 class="text-lg font-medium mb-2">Nombre d'Employés Actifs</h3>
                <span class="text-4xl font-bold text-green-600">
                    {{ $activeEmployeesCount }}
                </span>
            </div>
        </div>
    </main>

    <script>
        // Configuration globale de Chart.js
        Chart.defaults.font.size = 12;

        @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance']))
        // ---------------------------
        // Finances (Pie Chart)
        const financeData = @json($financeStats);
        new Chart(document.getElementById('financeChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Revenus', 'Dépenses', 'Factures'],
                datasets: [{
                    data: [financeData.revenus, financeData.depenses, financeData.factures],
                    backgroundColor: ['rgba(0,104,255,0.6)', 'rgba(255,0,55,1)', 'rgba(255, 206, 86, 1)'],
                    borderColor: ['rgba(0,104,255,0.6)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
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

        @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'finance', 'manager', 'livreur']))
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
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: { beginAtZero: true, ticks: { stepSize: 1 } }
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

        @if (Auth::user()->hasAnyRole(['superadmin', 'admin', 'rh']))
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
                    backgroundColor: 'rgba(255, 159, 64, 0.6)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: { beginAtZero: true, ticks: { stepSize: 1 } }
                },
                plugins: { legend: { display: false } }
            }
        });
        @endif
    </script>
@endsection
