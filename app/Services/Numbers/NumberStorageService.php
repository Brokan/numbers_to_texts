<?php

declare(strict_types=1);

namespace App\Services\Numbers;

class NumberStorageService {

    private const FILE_LOCATION = 'app/stack.json';

    private string $file;

    public function __construct() {
        $this->file = storage_path(self::FILE_LOCATION);

        if (!file_exists($this->file)) {
            file_put_contents($this->file, json_encode([]));
        }
    }

    public function push(int $value): void {
        $stack = $this->read();

        $stack[] = $value;

        $this->write($stack);
    }

    public function pop(): ?int {
        $stack = $this->read();

        if (empty($stack)) {
            return null;
        }

        // LIFO
        $value = array_pop($stack);
        $this->write($stack);

        return (int)$value;
    }

    /**
     * @return array<int>
     */
    private function read(): array {
        $content = file_get_contents($this->file);
        if(!$content){
            return [];
        }
        
        /** @var array<int> $data */
        $data = json_decode($content, true) ?? [];
        
        return $data;
    }

    /**
     * @param array<int> $data
     */
    private function write(array $data): void {
        file_put_contents($this->file, json_encode($data));
    }
}
