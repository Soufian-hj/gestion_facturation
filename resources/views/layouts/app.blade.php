<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Application')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-xl font-bold">
                <a href="{{ route('clients.index') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('assets/logo.png') }}" class="w-24" alt="Logo" />
                    <span>STE MTS SMART SARL</span>
                </a>
            </div>
            <ul class="flex space-x-6 text-gray-700 font-medium">
                <li><a href="{{ route('clients.index') }}" class="hover:text-blue-600">Clients</a></li>
                <li><a href="{{ route('produits.index') }}" class="hover:text-blue-600">Produits</a></li>
                <li><a href="{{ route('factures.index') }}" class="hover:text-blue-600">Factures</a></li>
                <li><a href="{{ route('ligne_factures.index') }}" class="hover:text-blue-600">Ligne Factures</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6">
        @yield('content')
    </main>

</body>
</html>
