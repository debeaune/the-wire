<?php

echo "CommentRepository chargé !";
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/Comment.php';

class CommentRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM comments ORDER BY date DESC");
        $rows = $stmt->fetchAll();
        $comments = [];
        foreach ($rows as $row) {
            $comments[] = new Comment(
                $row['id'],
                $row['nom'],
                $row['contenu'],
                $row['date'],
                $row['articleId'],
            );
        }
        return $comments;
    }

    public function findById(int $id): ?Comment {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        return new Comment(
            $row['id'],
            $row['nom'],
            $row['contenu'],
            $row['date'],
            $row['articleId'],
        );
    }

    public function findByArticleId(int $articleId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE articleId = ? ORDER BY date DESC");
        $stmt->execute([$articleId]);
        $rows = $stmt->fetchAll();
        $comments = [];
        foreach ($rows as $row) {
            $comments[] = new Comment(
                $row['id'],
                $row['nom'],
                $row['contenu'],
                $row['date'],
                $row['articleId'],
            );
        }
        return $comments;
    }

    public function save(Comment $comment): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO comments (nom, contenu, date, articleId)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $comment->getNom(),
            $comment->getContenu(),
            $comment->getDate(),
            $comment->getArticleId(),
        ]);
    }
}