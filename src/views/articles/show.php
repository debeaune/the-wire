<?php ob_start(); ?>

<div class="max-w-3xl mx-auto">

    <!-- Article -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <?php if ($article->getImage()): ?>
        <img src="<?= htmlspecialchars($article->getImage()) ?>" alt="<?= htmlspecialchars($article->getTitre()) ?>" class="w-full h-64 object-cover">
        <?php endif; ?>
        <div class="p-8">
            <span class="text-xs text-gray-400 uppercase tracking-wider"><?= htmlspecialchars($article->getSource() ?? '') ?></span>
            <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-4"><?= htmlspecialchars($article->getTitre()) ?></h1>
            <p class="text-gray-500 text-sm mb-6">Par <?= htmlspecialchars($article->getAuteur()) ?> — <?= htmlspecialchars($article->getDatePublication()) ?></p>
            <p class="text-gray-700 leading-relaxed"><?= htmlspecialchars($article->getContenu()) ?></p>
            <a href="<?= htmlspecialchars($article->getUrl()) ?>" target="_blank" class="inline-block mt-6 px-6 py-3 bg-gray-900 text-white rounded-xl hover:bg-gray-700 transition-colors">
                Lire l'article complet →
            </a>
            <!-- Réactions -->
            <?php
                $counts = [];
                foreach ($reactions as $r) {
                    $counts[$r['type']] = $r['total'];
                }
            ?>

            <div class="flex gap-4 mt-6">
                <form action="/reactions/store" method="POST">
                    <input type="hidden" name="articleId" value="<?= $article->getId() ?>">
                    <input type="hidden" name="type" value="like">
                    <button type="submit" class="text-2xl hover:scale-125 transition-transform">
                        👍 <?= $counts['like'] ?? 0 ?>
                    </button>
                </form>
                <form action="/reactions/store" method="POST">
                    <input type="hidden" name="articleId" value="<?= $article->getId() ?>">
                    <input type="hidden" name="type" value="love">
                    <button type="submit" class="text-2xl hover:scale-125 transition-transform">
                        ❤️ <?= $counts['love'] ?? 0 ?>
                    </button>
                </form>
                <form action="/reactions/store" method="POST">
                    <input type="hidden" name="articleId" value="<?= $article->getId() ?>">
                    <input type="hidden" name="type" value="wow">
                    <button type="submit" class="text-2xl hover:scale-125 transition-transform">
                        😮 <?= $counts['wow'] ?? 0 ?>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Fil de commentaires -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Commentaires</h2>
        <?php if (empty($comments)): ?>
            <p class="text-gray-400">Aucun commentaire pour l'instant.</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
            <div class="bg-white rounded-xl p-4 mb-3 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-medium text-gray-900"><?= htmlspecialchars($comment->getNom()) ?></span>
                    <span class="text-xs text-gray-400"><?= htmlspecialchars($comment->getDate()) ?></span>
                </div>
                <p class="text-gray-600 text-sm"><?= htmlspecialchars($comment->getContenu()) ?></p>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Formulaire commentaire -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Laisser un commentaire</h3>
        <form action="/comments/store" method="POST">
            <input type="hidden" name="articleId" value="<?= $article->getId() ?>">
            <div class="mb-4">
                <input type="text" name="nom" placeholder="Votre nom" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900">
            </div>
            <div class="mb-4">
                <textarea name="contenu" placeholder="Votre commentaire" required rows="4"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900"></textarea>
            </div>
            <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-xl hover:bg-gray-700 transition-colors">
                Publier
            </button>
        </form>
    </div>

</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';