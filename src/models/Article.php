<?php

class Article {
    private int $id;
    private string $titre;
    private string $auteur;
    private ?string $sousTitre;
    private string $contenu;
    private ?string $image;
    private ?string $source;
    private string $url;
    private string $datePublication;
    private ?string $categorie;

    public function __construct(
        int $id,
        string $titre,
        string $auteur,
        ?string $sousTitre,
        string $contenu,
        ?string $image,
        ?string $source,
        string $url,
        string $datePublication,
        ?string $categorie
    ) {
        $this->id = $id;
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->sousTitre = $sousTitre;
        $this->contenu = $contenu;
        $this->image = $image;
        $this->source = $source;
        $this->url = $url;
        $this->datePublication = $datePublication;
        $this->categorie = $categorie;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getAuteur(): string {
        return $this->auteur;
    }

    public function getSousTitre(): ?string {
        return $this->sousTitre;
    }

    public function getContenu(): string {
        return $this->contenu;
    }

    public function getImage(): ?string {
        return $this->image;
    }

    public function getSource(): ?string {
        return $this->source;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getDatePublication(): string {
        return $this->datePublication;
    }

    public function getCategorie(): ?string {
        return $this->categorie;
    }
}