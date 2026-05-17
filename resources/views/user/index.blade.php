<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Employé</title>
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen" style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);">
    <!-- Header -->
    <header
        class="sticky top-0 z-50 flex flex-col gap-2 p-4 md:flex-row md:justify-between md:items-center md:px-[30px] md:py-[15px] text-white shadow-[0_4px_15px_rgba(56,214,44,0.2)]"
        style="background: linear-gradient(45deg, #38d62c 0%, #55deaf 100%);">
        <div class="text-xl md:text-2xl font-medium drop-shadow-sm">Mon Profil</div>
        <div class="flex flex-col gap-2 w-full md:flex-row md:gap-[15px] md:w-auto">
            <!-- Bouton Retour au tableau de bord -->
            <a href="{{ route('dashboard') }}"
                class="bg-[#87e8b6] text-white py-1.5 px-3 text-sm w-full text-center md:py-2 md:px-4 md:text-base md:w-auto rounded-[10px] no-underline transition-transform duration-300 ease-in-out shadow-[0_2px_8px_rgba(135,232,182,0.3)] hover:bg-[#55deaf] hover:scale-105">
                <i class="fas fa-tachometer-alt"></i> Tableau de bord
            </a>
            <!-- Bouton de déconnexion -->
            <a href="{{ route('logout') }}"
                class="bg-[#55deaf] text-white py-1.5 px-3 text-sm w-full text-center md:py-2 md:px-4 md:text-base md:w-auto rounded-[10px] no-underline transition-transform duration-300 ease-in-out shadow-[0_2px_8px_rgba(85,222,175,0.3)] hover:bg-[#38d62c] hover:scale-105"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
        </div>
    </header>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
    <div>
        @if (session('error'))
            <div
                class="flex items-center gap-3 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow mb-4">
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

    </div>

    <div class="max-w-[1100px] mx-auto p-[30px]">
        <div
            class="bg-white rounded-[20px] mb-[25px] transition-all duration-300 shadow-[0_4px_15px_rgba(0,0,0,0.08)] hover:-translate-y-2 hover:shadow-[0_8px_25px_rgba(0,0,0,0.12)]">
            <div
                class="bg-[#fefefe] border-b border-[#f1f3f5] px-[25px] py-[15px] text-[1.15rem] font-medium text-[#2d3436] flex justify-between items-center rounded-t-[20px]">
                <span>Informations personnelles</span>
                <a href="{{ route('user.edit', auth()->user()->id_utilisateur) }}"
                    class="bg-[#87e8b6] text-white py-1.5 px-3 text-sm w-full text-center md:py-2 md:px-4 md:text-base md:w-auto rounded-[10px] no-underline transition-transform duration-300 ease-in-out hover:bg-[#55deaf] hover:scale-105">
                    <i class="fas fa-plus"></i> Éditer mon profil
                </a>
            </div>
            <div class="p-[25px]">
                <ul class="list-none p-0 m-0">
                    <li class="py-3 border-b border-[#f1f3f5] flex justify-between items-center text-sm">
                        <span class="font-medium text-[#2d3436]">Nom</span>
                        <span class="text-[#636e72]">{{ auth()->user()->username }}</span>
                    </li>
                    <li class="py-3 border-b border-[#f1f3f5] flex justify-between items-center text-sm">
                        <span class="font-medium text-[#2d3436]">Email</span>
                        <span class="text-[#636e72]">{{ auth()->user()->email }}</span>
                    </li>
                    <li class="py-3 flex justify-between items-center text-sm">
                        <span class="font-medium text-[#2d3436]">Date d'inscription</span>
                        <span class="text-[#636e72]">{{ auth()->user()->date_creation->format('d/m/Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Section des congés -->
        <div
            class="bg-white rounded-[20px] mb-[25px] transition-all duration-300 shadow-[0_4px_15px_rgba(0,0,0,0.08)] hover:-translate-y-2 hover:shadow-[0_8px_25px_rgba(0,0,0,0.12)]">
            <div
                class="bg-[#fefefe] border-b border-[#f1f3f5] px-[25px] py-[15px] text-[1.15rem] font-medium text-[#2d3436] flex justify-between items-center rounded-t-[20px]">
                <span>Vos congés</span>
                <div class="flex flex-col gap-2 w-full md:flex-row md:gap-2 md:w-auto">
                    <input type="text"
                        class="max-w-[180px] py-2 px-3 border border-[#dfe4ea] rounded-[10px] text-[0.85rem] transition-all duration-300 focus:outline-none focus:border-[#55deaf] focus:shadow-[0_0_8px_rgba(85,222,175,0.2)]"
                        id="congeFilter" placeholder="Filtrer par type ou statut...">
                    <a href="{{ route('conges.create') }}"
                        class="bg-[#87e8b6] text-white py-1.5 px-3 text-sm w-full text-center md:py-2 md:px-4 md:text-base md:w-auto rounded-[10px] no-underline transition-transform duration-300 ease-in-out hover:bg-[#55deaf] hover:scale-105">
                        <i class="fas fa-plus"></i> Demande de congé
                    </a>
                </div>
            </div>
            <div class="p-[25px]">
                @if($conges->isEmpty())
                    <p class="text-center text-[#b2bec3] italic text-sm">Vous n'avez aucun congé pour le moment.</p>
                @else
                            <table class="w-full border-separate border-spacing-0">
                                <thead>
                                    <tr>
                                        <th class="bg-[#f7f9fb] text-[#2d3436] font-medium py-3 px-[15px]">Date de début</th>
                                        <th class="bg-[#f7f9fb] text-[#2d3436] font-medium py-3 px-[15px]">Date de fin</th>
                                        <th class="bg-[#f7f9fb] text-[#2d3436] font-medium py-3 px-[15px]">Type</th>
                                        <th class="bg-[#f7f9fb] text-[#2d3436] font-medium py-3 px-[15px]">Statut</th>
                                    </tr>
                                </thead>
                                <tbody id="congeTableBody">
                                    @foreach($conges as $conge)
                                                        <tr class="border-b border-[#f1f3f5] hover:bg-[#f9fbfc]">
                                                            <td class="py-3 px-[15px] text-[#636e72]">{{ $conge->date_debut }}</td>
                                                            <td class="py-3 px-[15px] text-[#636e72]">{{ $conge->date_fin }}</td>
                                                            <td class="py-3 px-[15px] text-[#636e72]">{{ $conge->type_conge }}</td>
                                                            <td class="py-3 px-[15px] @class([
                                                                'text-[#f1c40f] font-medium' => strtolower($conge->statut) === 'en attente',
                                                                'text-[#38d62c] font-medium' => strtolower($conge->statut) === 'validé',
                                                                'text-[#e74c3c] font-medium' => strtolower($conge->statut) === 'annulé',
                                                                'text-[#636e72]' => !in_array(strtolower($conge->statut), ['en attente', 'validé', 'annulé'])
                                                            ])">
                                                                {{ $conge->statut }}
                                                            </td>
                                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                @endif
            </div>
        </div>

        <!-- Section des salaires -->
        <div
            class="bg-white rounded-[20px] mb-[25px] transition-all duration-300 shadow-[0_4px_15px_rgba(0,0,0,0.08)] hover:-translate-y-2 hover:shadow-[0_8px_25px_rgba(0,0,0,0.12)]">
            <div
                class="bg-[#fefefe] border-b border-[#f1f3f5] px-[25px] py-[15px] text-[1.15rem] font-medium text-[#2d3436] flex justify-between items-center rounded-t-[20px]">
                <span>Vos salaires</span>
                <div class="flex flex-col gap-2 w-full md:flex-row md:gap-2 md:w-auto">
                    <input type="text"
                        class="max-w-[180px] py-2 px-3 border border-[#dfe4ea] rounded-[10px] text-[0.85rem] transition-all duration-300 focus:outline-none focus:border-[#55deaf] focus:shadow-[0_0_8px_rgba(85,222,175,0.2)]"
                        id="salaireFilter" placeholder="Filtrer par date...">
                </div>
            </div>
            <div class="p-[25px]">
                @if($salaires->isEmpty())
                    <p class="text-center text-[#b2bec3] italic text-sm">Vous n'avez aucun salaire enregistré pour le
                        moment.</p>
                @else
                    <table class="w-full border-separate border-spacing-0">
                        <thead>
                            <tr>
                                <th class="bg-[#f7f9fb] text-[#2d3436] font-medium py-3 px-[15px]">Montant</th>
                                <th class="bg-[#f7f9fb] text-[#2d3436] font-medium py-3 px-[15px]">Date de début</th>
                                <th class="bg-[#f7f9fb] text-[#2d3436] font-medium py-3 px-[15px]">Date de fin</th>
                            </tr>
                        </thead>
                        <tbody id="salaireTableBody">
                            @foreach($salaires as $salaire)
                                <tr class="border-b border-[#f1f3f5] hover:bg-[#f9fbfc]">
                                    <td class="py-3 px-[15px] text-[#636e72]">{{ $salaire->montant }} €</td>
                                    <td class="py-3 px-[15px] text-[#636e72]">{{ $salaire->date_debut }}</td>
                                    <td class="py-3 px-[15px] text-[#636e72]">{{ $salaire->date_fin }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript personnalisé -->
    <script>
        // Filtrer les congés
        document.getElementById('congeFilter').addEventListener('input', function (e) {
            const filter = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#congeTableBody tr');

            rows.forEach(row => {
                const type = row.cells[2].textContent.toLowerCase();
                const statut = row.cells[3].textContent.toLowerCase();

                if (type.includes(filter) || statut.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Filtrer les salaires
        document.getElementById('salaireFilter').addEventListener('input', function (e) {
            const filter = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#salaireTableBody tr');

            rows.forEach(row => {
                const dateDebut = row.cells[1].textContent.toLowerCase();
                const dateFin = row.cells[2].textContent.toLowerCase();

                if (dateDebut.includes(filter) || dateFin.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Animation d'apparition des cartes
        document.querySelectorAll('.card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 200);
        });
    </script>
</body>

</html>