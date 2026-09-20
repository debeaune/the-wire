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

        if ($articleId && in_array($type, ['like', 'favori', 'interessant'])) {
            $reaction = new Reaction(0, $articleId, $type, date('Y-m-d H:i:s'));
            $this->reactionRepository->save($reaction);
        }

         // Si requête AJAX → retourner JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            $counts = $this->reactionRepository->countByArticleId($articleId);
            $result = [];
            foreach ($counts as $row) {
                $result[$row['type']] = $row['total'];
            }
            while (ob_get_level() > 0) ob_end_clean();
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }

        header('Location: /article/' . $articleId);
        exit;       
    }
}