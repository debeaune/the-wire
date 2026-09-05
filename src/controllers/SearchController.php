<?php

require_once __DIR__ . '/../models/ArticleRepository.php';

class SearchController {
    private ArticleRepository $articleRepository;

    public function __construct() {
        $this->articleRepository = new ArticleRepository();
    }

    public function search(): void {
        $query = $_GET['q'] ?? '';
        $articles = [];
        
        if (!empty($query)) {
            $articles = $this->articleRepository->search($query);
        }
        
        require_once __DIR__ . '/../views/search/index.php';
    }
}