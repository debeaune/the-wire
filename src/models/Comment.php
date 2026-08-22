<?php

class Comment {
    private int $id;
    private string $nom;
    private string $contenu;
    private string $date;
    private int $articleId;

public function __construct(
    int $id,
    string $nom,
    string $contenu,
    string $date,
    int $articleId
    ) {
    $this->id = $id;
    $this->nom = $nom;
    $this->contenu = $contenu;
    $this->date = $date;
    $this->articleId = $articleId;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getContenu(): string {
        return $this->contenu;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function getArticleId(): int {
        return $this->articleId;
    } 
}  
