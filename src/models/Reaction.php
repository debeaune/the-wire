<?php

class Reaction {
    private int $id;
    private int $articleId;
    private string $type;
    private string $dateReaction;

    public function __construct(
        int $id,
        int $articleId,
        string $type,
        string $dateReaction
    ) {
        $this->id = $id;
        $this->articleId = $articleId;
        $this->type = $type;
        $this->dateReaction = $dateReaction;
    }

    public function getId(): int { return $this->id; }
    public function getArticleId(): int { return $this->articleId; }
    public function getType(): string { return $this->type; }
    public function getDateReaction(): string { return $this->dateReaction; }
}