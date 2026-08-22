<?php

require_once __DIR__ . '/../models/MessageRepository.php';
require_once __DIR__ . '/../models/Message.php';

class MessageController {
    private MessageRepository $messageRepository;

    public function __construct() {
        $this->messageRepository = new MessageRepository();
    }

    public function index(): void {
        $messages = $this->messageRepository->findAll();
        require_once __DIR__ . '/../views/messages/index.php';
    }

    public function store(): void {
        $auteur = $_POST['auteur'] ?? '';
        $contenu = $_POST['contenu'] ?? '';
        $langue = $_POST['langue'] ?? 'fr';
        $datePublication = date('Y-m-d H:i:s');

        $message = new Message(0, $auteur, $contenu, $datePublication, $langue);
        $this->messageRepository->save($message);

        header('Location: /salon');
    }
}