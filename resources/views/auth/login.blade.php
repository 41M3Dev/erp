<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        .backdrop-blur {
            backdrop-filter: blur(10px);
        }

        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#38d62c] to-[#55deaf] flex items-center justify-center">



    <div id="main-content" class="w-full flex items-center justify-center">
        <div class="bg-white bg-opacity-90 backdrop-blur p-10 rounded-xl shadow-2xl w-full max-w-md">
            <div class="mb-6 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Bienvenue</h1>
                <p class="text-gray-600 mt-2">Connectez-vous pour continuer</p>
            </div>

            @if (session('success'))
                <div style="color: green;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div style="color: red;">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="color: red;">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium mb-2">Pseudo</label>
                    <input type="text" name="username" id="username" placeholder="Votre username" required autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>
                <div class="mb-6">
                    <label for="mot_de_passe" class="block text-gray-700 font-medium mb-2">Mot de passe</label>
                    <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="Votre mot de passe"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#38d62c]">
                </div>
                <button type="submit"
                    class="w-full py-3 bg-[#38d62c] text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition duration-300 cursor-pointer">Se
                    connecter</button>
            </form>

            <div class="mt-8">
                <p class="text-center text-gray-500 text-sm mb-3">Comptes de démonstration</p>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" onclick="remplir('superadmin', 'Password123!')"
                        class="text-white bg-purple-600 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-purple-800 cursor-pointer transition duration-300">
                        Super Admin
                    </button>
                    <button type="button" onclick="remplir('admin', 'Password123!')"
                        class="text-white bg-blue-600 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800 cursor-pointer transition duration-300">
                        Admin
                    </button>
                    <button type="button" onclick="remplir('manager.dubois', 'Password123!')"
                        class="text-white bg-yellow-500 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-yellow-700 cursor-pointer transition duration-300">
                        Manager
                    </button>
                    <button type="button" onclick="remplir('employe.petit', 'Password123!')"
                        class="text-white bg-gray-500 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-gray-700 cursor-pointer transition duration-300">
                        Employé
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function remplir(username, password) {
            document.getElementById('username').value = username;
            document.getElementById('mot_de_passe').value = password;
        }
    </script>
</body>

</html>