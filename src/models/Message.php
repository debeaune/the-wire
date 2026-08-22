<?php

class Message {
    private int $id;
    private string $auteur;
    private string $contenu;
    private string $datePublication;
    private string $langue;

    public function __construct(
        int $id,
        string $auteur,
        string $contenu,
        string $datePublication,
        string $langue
    ) {
        $this->id = $id;
        $this->auteur = $auteur;
        $this->contenu = $contenu;
        $this->datePublication = $datePublication;
        $this->langue = $langue;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getAuteur(): string {
        return $this->auteur;
    }

    public function getContenu(): string {
        return $this->contenu;
    }

    public function getDatePublication(): string {
        return $this->datePublication;
    }

    public function getLangue(): string {
        return $this->langue;
    }
}