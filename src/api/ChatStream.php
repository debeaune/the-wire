<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/MessageRepository.php';

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

$messageRepository = new MessageRepository();
$lastId = isset($_SERVER['HTTP_LAST_EVENT_ID']) 
    ? (int) $_SERVER['HTTP_LAST_EVENT_ID'] 
    : 0;

while (true) {
    $messages = $messageRepository->findNewMessages($lastId);
    foreach ($messages as $message) {
        $lastId = $message->getId();
        echo "id: " . $message->getId() . "\n";
        echo "data: " . json_encode([
            'auteur' => $message->getAuteur(),
            'contenu' => $message->getContenu(),
            'langue' => $message->getLangue(),
            'date' => $message->getDatePublication()
        ]) . "\n\n";
    }
    if (ob_get_level() > 0) ob_flush();
    flush();
    sleep(1);
}