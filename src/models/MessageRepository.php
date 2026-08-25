<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/Message.php';

class MessageRepository {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM messages ORDER BY datePublication DESC");
        $rows = $stmt->fetchAll();
        $messages = [];
        foreach ($rows as $row) {
            $messages[] = new Message(
                $row['id'],
                $row['auteur'],
                $row['contenu'],
                $row['datePublication'],
                $row['langue'],
            );
        }
        return $messages;
    }

    public function findById(int $id): ?Message {
        $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        return new Message(
            $row['id'],
            $row['auteur'],
            $row['contenu'],
            $row['datePublication'],
            $row['langue'],
        );
    }

    public function save(Message $message): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO messages (auteur, contenu, datePublication, langue)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $message->getAuteur(),
            $message->getContenu(),
            $message->getDatePublication(),
            $message->getLangue(),
        ]);
    }
}
