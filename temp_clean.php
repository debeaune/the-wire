<?php
require_once 'src/classes/Database.php';
$pdo = Database::getInstance()->getPdo();
$pdo->exec("DELETE FROM messages");
echo "Messages vidés !";