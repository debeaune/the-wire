<?php

require_once __DIR__ . '/../models/ArticleRepository.php';
require_once __DIR__ . '/../api/NewsService.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/CommentRepository.php';

class ArticleController {
    private ArticleRepository $articleRepository;
    private NewsService $newsService;

    public function __construct() {
        $this->articleRepository = new ArticleRepository();
        $this->newsService = new NewsService();
    }

    public function index(): void {
        $pays = $_GET['pays'] ?? 'fr';
        $categorie = $_GET['categorie'] ?? 'technology';
        $articles = $this->newsService->fetchArticles($categorie, $pays);

        foreach ($articles as $article) {
            $this->articleRepository->save($article);
        }
    
        require_once __DIR__ . '/../views/articles/index.php';
    }

    public function show(int $id): void {
        $article = $this->articleRepository->findById($id);
        if (!$article) {
            header('Location: /');
            return;
        }
        $commentRepository = new CommentRepository();
        $comments = $commentRepository->findByArticleId($id);

        require_once __DIR__ . '/../models/ReactionRepository.php';
       
        $reactionRepository = new ReactionRepository();
        $reactions = $reactionRepository->countByArticleId($id);

        require_once __DIR__ . '/../views/articles/show.php';
    }

    public function store(): void {
        $article = new Article(
            0,
            $_POST['titre'] ?? '',
            $_POST['auteur'] ?? 'Inconnu',
            null,
            $_POST['contenu'] ?? '',
            $_POST['image'] ?? null,
            $_POST['source'] ?? null,
            $_POST['url'] ?? '',
            date('Y-m-d'),
            null
        );
        $articleId = $this->articleRepository->save($article);
        header('Location: /article/' . $articleId);
        exit;
    }
}