<?php

class Database {
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct() {
        $this->pdo = new PDO('sqlite:' . __DIR__ . '/../../database.sqlite');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $this->pdo->exec('PRAGMA journal_mode = WAL;');
        $this->pdo->exec('PRAGMA synchronous = NORMAL;');
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getPdo(): PDO {
        return $this->pdo;
    }
}