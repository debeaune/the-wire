<?php

require_once __DIR__ . '/src/classes/Database.php';

$pdo = Database::getInstance()->getPdo();

$articles = [
    [
        'titre' => 'La France lance un plan IA pour 2026',
        'auteur' => 'Jean Dupont',
        'contenu' => 'Le gouvernement français annonce un investissement massif dans l\'intelligence artificielle pour renforcer la compétitivité du pays.',
        'image' => null,
        'source' => 'Le Monde',
        'url' => 'https://lemonde.fr',
        'datePublication' => '2026-09-20 10:00:00',
        'categorie' => 'technology'
    ],
    [
        'titre' => 'Cybersécurité : les nouvelles menaces en 2026',
        'auteur' => 'Marie Martin',
        'contenu' => 'Les experts en sécurité informatique alertent sur une recrudescence des attaques par ransomware ciblant les infrastructures critiques.',
        'image' => null,
        'source' => 'Le Figaro',
        'url' => 'https://lefigaro.fr',
        'datePublication' => '2026-09-20 11:00:00',
        'categorie' => 'technology'
    ],
    [
        'titre' => 'Linux domine les serveurs mondiaux',
        'auteur' => 'Pierre Durand',
        'contenu' => 'Une étude récente confirme que Linux est utilisé sur plus de 90% des serveurs dans le monde, consolidant sa position dominante.',
        'image' => null,
        'source' => 'ZDNet',
        'url' => 'https://zdnet.fr',
        'datePublication' => '2026-09-20 12:00:00',
        'categorie' => 'technology'
    ],
];

$stmt = $pdo->prepare("
    INSERT INTO articles (titre, auteur, contenu, image, source, url, datePublication, categorie)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

foreach ($articles as $a) {
    $stmt->execute([
        $a['titre'], $a['auteur'], $a['contenu'],
        $a['image'], $a['source'], $a['url'],
        $a['datePublication'], $a['categorie']
    ]);
}

echo "Articles insérés avec succès !";