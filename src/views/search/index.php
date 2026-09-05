<?php ob_start(); ?>

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Résultats de recherche</h1>
    <p class="text-gray-500">Recherche : "<?= htmlspecialchars($query) ?>"</p>
</div>

<?php if (empty($articles)): ?>
    <p class="text-gray-400">Aucun article trouvé pour "<?= htmlspecialchars($query) ?>".</p>
<?php else: ?>
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
                <form action="/article/store" method="POST">
                    <input type="hidden" name="titre" value="<?= htmlspecialchars($article->getTitre()) ?>">
                    <input type="hidden" name="image" value="<?= htmlspecialchars($article->getImage() ?? '') ?>">
                    <input type="hidden" name="contenu" value="<?= htmlspecialchars($article->getContenu()) ?>">
                    <input type="hidden" name="url" value="<?= htmlspecialchars($article->getUrl()) ?>">
                    <input type="hidden" name="auteur" value="<?= htmlspecialchars($article->getAuteur()) ?>">
                    <input type="hidden" name="source" value="<?= htmlspecialchars($article->getSource() ?? '') ?>">
                    <button type="submit" class="mt-4 text-sm font-medium text-gray-900 hover:underline bg-transparent border-none cursor-pointer p-0">
                        Lire l'article →
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../views/layout.php';