<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 — Session expirée</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex items-center justify-center p-4">
    <div class="text-center">
        <p class="text-8xl font-black text-slate-200">419</p>
        <h1 class="text-xl font-semibold text-slate-900 mt-4">Session expirée</h1>
        <p class="text-sm text-slate-500 mt-2">Votre session n'est plus valable, veuillez vous reconnecter.</p>
        <a href="{{ route('dashboard') }}"
            class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors mt-6">
            Retour à l'accueil
        </a>
    </div>
</body>

</html>
