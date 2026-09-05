<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wire — Fil d'actualité internationale</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
        <div class="flex flex-col">
            <a href="/" class="text-xl font-bold tracking-widest">THE WIRE</a>
            <span class="text-gray-400 text-sm">Fil d'actualité internationale</span>
        </div>
        <div class="flex gap-6">
            <a href="/" class="hover:text-gray-300 transition-colors">Actualités</a>
            <a href="/salon" class="hover:text-gray-300 transition-colors">Salon</a>
            <form action="/search" method="GET" class="flex items-center gap-2">
                <input type="text" name="q" placeholder="Rechercher..." 
                    class="border border-gray-700 bg-gray-800 text-white rounded-xl px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-white">
                <button type="submit" class="text-white text-sm hover:text-gray-300">🔍</button>
            </form>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="flex-1 max-w-6xl mx-auto w-full px-6 py-8">
        <?php echo $content ?? ''; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 text-center py-4 text-sm">
        © The Wire — Fil d'actualité internationale
    </footer>

</body>
</html>