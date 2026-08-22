<?php

class Storage {
    private string $storagePath;

    public function __construct(string $path = __DIR__ . '/../../storage/') {
        $this->storagePath = $path;
        if (!is_dir($this->storagePath)) {
            mkdir($this->storagePath, 0755, true);
        }
    }

    public function save(string $filename, array $data): bool {
        $filePath = $this->storagePath . $filename;
        return file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT)) !== false;
    }

    public function load(string $filename): ?array {
        $filePath = $this->storagePath . $filename;
        if (!file_exists($filePath)) return null;
        return json_decode(file_get_contents($filePath), true);
    }

    public function delete(string $filename): bool {
        $filePath = $this->storagePath . $filename;
        if (file_exists($filePath)) return unlink($filePath);
        return false;
    }
}