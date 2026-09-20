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
            <?php foreach ([
                    'like' => ['label' => 'J\'aime', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>'],
                    'favori' => ['label' => 'Favori', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>'],
                    'interessant' => ['label' => 'Intéressant', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m1.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>'],
                ] as $type => $config): ?>
                <button 
                    class="reaction-btn flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 hover:border-gray-900 hover:bg-gray-50 transition-all duration-200"
                    data-type="<?= $type ?>"
                    data-article-id="<?= $article->getId() ?>"
                    data-csrf="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                    <?= $config['svg'] ?>
                        <span class="text-sm font-medium text-gray-700"><?= $config['label'] ?></span>
                        <span class="reaction-count text-sm text-gray-500" id="count-<?= $type ?>"><?= $counts[$type] ?? 0 ?></span>
                </button>
        <?php endforeach; ?>
    </div>

    <script>
        document.querySelectorAll('.reaction-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const articleId = this.dataset.articleId;
                const type = this.dataset.type;
                const csrf = this.dataset.csrf;

                // Animation
                this.classList.add('scale-95');
                setTimeout(() => this.classList.remove('scale-95'), 150);

                fetch('/reactions/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `articleId=${articleId}&type=${type}&csrf_token=${csrf}`
                })
                .then(res => res.json())
                .then(data => {
                    // Mettre à jour les compteurs
                    document.getElementById('count-like').textContent = data.like ?? 0;
                    document.getElementById('count-favori').textContent = data.favori ?? 0;
                    document.getElementById('count-interessant').textContent = data.interessant ?? 0;
                });
            });
        });
    </script>

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
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
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