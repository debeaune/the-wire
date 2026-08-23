<?php

require_once  __DIR__ . '/src/classes/Database.php';

$pdo = Database::getInstance()->getPdo();

$sql = file_get_contents(__DIR__ . '/database.sql');
$pdo->exec($sql);

echo "Tables créées avec succès !";