<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/Article.php';

class ArticleRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM articles ORDER BY datePublication DESC");
        $rows = $stmt->fetchAll();
        $articles = [];
        foreach ($rows as $row) {
            $articles[] = new Article(
                $row['id'],
                $row['titre'],
                $row['auteur'],
                $row['sousTitre'],
                $row['contenu'],
                $row['image'],
                $row['source'],
                $row['url'],
                $row['datePublication'],
                $row['categorie']
            );
        }
        return $articles;
    }

    public function findById(int $id): ?Article {
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        return new Article(
            $row['id'],
            $row['titre'],
            $row['auteur'],
            $row['sousTitre'],
            $row['contenu'],
            $row['image'],
            $row['source'],
            $row['url'],
            $row['datePublication'],
            $row['categorie']
        );
    }

    public function save(Article $article): int {
    // Vérifier si l'article existe déjà ← ICI EN PREMIER
    $check = $this->pdo->prepare("SELECT id FROM articles WHERE url = ?");
    $check->execute([$article->getUrl()]);
    $existing = $check->fetch();
    
    if ($existing) {
        return (int) $existing['id'];
    }
        $stmt = $this->pdo->prepare("
            INSERT INTO articles (titre, auteur, sousTitre, contenu, image, source, url, datePublication, categorie)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $article->getTitre(),
            $article->getAuteur(),
            $article->getSousTitre(),
            $article->getContenu(),
            $article->getImage(),
            $article->getSource(),
            $article->getUrl(),
            $article->getDatePublication(),
            $article->getCategorie()
        ]);

        $articleId = (int) $this->pdo->lastInsertId();

        $stmt2 = $this->pdo->prepare("
            INSERT INTO articles_fts(rowid, titre, contenu, source)
            VALUES (?, ?, ?, ?)
        ");
        $stmt2->execute([
            $articleId,
            $article->getTitre(),
            $article->getContenu(),
            $article->getSource() ?? ''
        ]);

        return $articleId;
    }

    public function search(string $query): array {
        $stmt = $this->pdo->prepare("
            SELECT articles.* FROM articles
            JOIN articles_fts ON articles.id = articles_fts.rowid
            WHERE articles_fts MATCH ?
            ORDER BY rank
        ");
        $stmt->execute([$query]);
        $rows = $stmt->fetchAll();
        $articles = [];
        foreach ($rows as $row) {
            $articles[] = new Article(
                $row['id'],
                $row['titre'],
                $row['auteur'],
                $row['sousTitre'] ?? null,
                $row['contenu'],
                $row['image'] ?? null,
                $row['source'] ?? null,
                $row['url'],
                $row['datePublication'],
                $row['categorie'] ?? null
            );
        }
        return $articles;
    }
}