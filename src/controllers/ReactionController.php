<?php

require_once __DIR__ . '/../models/ReactionRepository.php';
require_once __DIR__ . '/../models/Reaction.php';

class ReactionController {
    private ReactionRepository $reactionRepository;

    public function __construct() {
        $this->reactionRepository = new ReactionRepository();
    }

    public function store(): void {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            http_response_code(403);
            die('Token CSRF invalide');
        }
        $articleId = (int) $_POST['articleId'] ?? 0;
        $type = $_POST['type'] ?? '';

        if ($articleId && in_array($type, ['like', 'love', 'wow'])) {
            $reaction = new Reaction(0, $articleId, $type, date('Y-m-d H:i:s'));
            $this->reactionRepository->save($reaction);
        }

        header('Location: /article/' . $articleId);
        exit;
    }
}