<?php ob_start(); ?>

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Salon de discussion</h1>
        <p class="text-gray-500">Échangez en temps réel sur l'actualité internationale</p>
    </div>

    <!-- Messages -->
    <div id="messages" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 h-64 md:h-96 overflow-y-auto">
        <?php foreach ($messages as $message): ?>
        <div class="mb-4">
            <div class="flex items-center gap-2 mb-1">
                <span class="font-medium text-gray-900"><?= htmlspecialchars($message->getAuteur()) ?></span>
                <span class="text-xs text-gray-400"><?= htmlspecialchars($message->getDatePublication()) ?></span>
                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full"><?= htmlspecialchars($message->getLangue()) ?></span>
            </div>
            <p class="text-gray-700"><?= htmlspecialchars($message->getContenu()) ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Formulaire message -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="/messages/store" method="POST" class="flex flex-col gap-4">
            <input type="text" name="auteur" placeholder="Votre nom" required
                class="border border-gray-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900">
            <select name="langue" class="border border-gray-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900">
                <option value="fr">🇫🇷 Français</option>
                <option value="en">🇬🇧 English</option>
                <option value="de">🇩🇪 Deutsch</option>
                <option value="es">🇪🇸 Español</option>
            </select>
            <textarea name="contenu" placeholder="Votre message..." required rows="3"
                class="border border-gray-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900"></textarea>
            <button type="submit" class="bg-gray-900 text-white px-6 py-3 rounded-xl hover:bg-gray-700 transition-colors">
                Envoyer →
            </button>
        </form>
    </div>

</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';