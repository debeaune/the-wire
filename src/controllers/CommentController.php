<?php

require_once __DIR__ . '/../models/CommentRepository.php';
require_once __DIR__ . '/../models/Comment.php';

class CommentController {
    private CommentRepository $commentRepository;

    public function __construct() {
        $this->commentRepository = new CommentRepository();
    }

    public function index(int $articleId): void {
        $comments = $this->commentRepository->findAll();
        require_once __DIR__ . '/../views/comments/index.php';
    }

    public function store(): void {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            http_response_code(403);
            die('Token CSRF invalide');
        }
        $nom = $_POST['nom'] ?? '';
        $contenu = $_POST['contenu'] ?? '';
        $articleId = (int) $_POST['articleId'] ?? 0;
        $date = date('Y-m-d H:i:s');

        $comment = new Comment(0, $nom, $contenu, $date, $articleId);
        $this->commentRepository->save($comment);

        header('Location: /article/'. $articleId);
    }
}