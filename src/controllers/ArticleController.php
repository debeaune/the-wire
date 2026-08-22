<?php

require_once __DIR__ . '/../models/ArticleRepository.php';

class ArticleController {
    private ArticleRepository $articleRepository;

    public function __construct() {
        $this->articleRepository = new ArticleRepository();
    }

    public function index(): void {
        $articles = $this->articleRepository->findAll();
        require_once __DIR__ . '/../views/articles/index.php';
    }

    public function show(int $id): void {
        $article = $this->articleRepository->findById($id);
        if (!$article) {
            http_response_code(404);
            return;
        }
        require_once __DIR__ . '/../views/articles/show.php';
    }
}