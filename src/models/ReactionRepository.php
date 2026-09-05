<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/Reaction.php';

class ReactionRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function save(Reaction $reaction): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO reactions (articleId, type, dateReaction)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([
            $reaction->getArticleId(),
            $reaction->getType(),
            $reaction->getDateReaction()
        ]);
    }

    public function countByArticleId(int $articleId): array {
        $stmt = $this->pdo->prepare("
            SELECT type, COUNT(*) as total
            FROM reactions
            WHERE articleId = ?
            GROUP BY type
        ");
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }
}