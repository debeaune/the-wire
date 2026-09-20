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
    
        // Essayer l'API externe
        $articlesFromApi = $this->newsService->fetchArticles($categorie, $pays);
    
        // Si l'API répond, on sauvegarde
        foreach ($articlesFromApi as $article) {
            $this->articleRepository->save($article);
        }
    
        // Dans tous les cas, on affiche ce qui est en base
        $articles = $this->articleRepository->findAll();

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
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            http_response_code(403);
            die('Token CSRF invalide');
        }
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