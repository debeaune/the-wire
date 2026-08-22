<?php

require_once __DIR__ . '/../models/Article.php';

class NewsService {
    private string $baseUrl = 'https://saurav.tech/NewsAPI/top-headlines/category/';

    private function fetch(string $url): ?array {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode !== 200 || !$response) return null;
        return json_decode($response, true);
    }

    public function fetchArticles(string $categorie = 'technology', string $pays = 'fr'): array {
        $url = $this->baseUrl . $categorie . '/' . $pays . '.json';
        $data = $this->fetch($url);
        if (!$data || !isset($data['articles'])) return [];
        $articles = [];
        foreach ($data['articles'] as $item) {
            $articles[] = new Article(
                0,
                $item['title'] ?? '',
                $item['author'] ?? 'Inconnu',
                null,
                $item['description'] ?? '',
                $item['urlToImage'] ?? null,
                $item['source']['name'] ?? null,
                $item['url'] ?? '',
                $item['publishedAt'] ?? date('Y-m-d H:i:s'),
                $categorie
            );
        }
        return $articles;
    }
}