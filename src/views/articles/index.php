<?php ob_start(); ?>

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Actualités</h1>
    <p class="text-gray-500">Fil d'actualité internationale en temps réel</p>
</div>

<!-- Filtres pays/langue -->
<div class="flex gap-3 mb-8">
    <a href="?pays=fr" class="px-4 py-2 bg-gray-900 text-white rounded-full text-sm">🇫🇷 France</a>
    <a href="?pays=us" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-full text-sm hover:bg-gray-900 hover:text-white transition-colors">🇺🇸 USA</a>
    <a href="?pays=gb" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-full text-sm hover:bg-gray-900 hover:text-white transition-colors">🇬🇧 UK</a>
</div>

<!-- Grille d'articles -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($articles as $article): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
        <?php if ($article->getImage()): ?>
        <img src="<?= htmlspecialchars($article->getImage()) ?>" alt="<?= htmlspecialchars($article->getTitre()) ?>" class="w-full h-48 object-cover">
        <?php endif; ?>
        <div class="p-5">
            <span class="text-xs text-gray-400 uppercase tracking-wider"><?= htmlspecialchars($article->getSource() ?? '') ?></span>
            <h2 class="text-lg font-bold text-gray-900 mt-1 mb-2 line-clamp-2"><?= htmlspecialchars($article->getTitre()) ?></h2>
            <p class="text-gray-500 text-sm line-clamp-3"><?= htmlspecialchars($article->getContenu()) ?></p>
            <a href="<?= htmlspecialchars($article->getUrl()) ?>" target="_blank" class="inline-block mt-4 text-sm font-medium text-gray-900 hover:underline">
                Lire l'article →
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';