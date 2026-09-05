<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/MessageRepository.php';

set_time_limit(0);

// 1. Vider les buffers EN PREMIER
while (ob_get_level() > 0) {
    ob_end_flush();
}

// 2. Fermer la session
if (session_status() === PHP_SESSION_ACTIVE) {
    session_write_close();
}

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('Access-Control-Allow-Origin: http://localhost:8000');

$messageRepository = new MessageRepository();
$lastId = isset($_SERVER['HTTP_LAST_EVENT_ID']) 
    ? (int) $_SERVER['HTTP_LAST_EVENT_ID'] 
    : 0;

while (true) {
    // Si le client est parti → on arrête proprement
    if (connection_aborted()) break;

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

    // Heartbeat → évite la coupure si pas de message
    echo ": ping\n\n";

    flush();
    usleep(500000);
}