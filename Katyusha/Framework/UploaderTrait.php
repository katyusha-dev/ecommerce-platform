<?php

namespace Katyusha\Framework;

use Illuminate\Contracts\Filesystem\Filesystem;

trait UploaderTrait
{
    abstract public function getDisk(): Filesystem;

    abstract public function getDiskBasePath(): string|null;

    public function storeFile(string $fileName, mixed $contents): bool
    {
        $basePath = $this->getDiskBasePath() ? $this->getDiskBasePath().'/' : '';

        return static::getDisk()->put($this->getDiskBasePath()."${basePath}/${fileName}", $contents);
    }

    public function storeBase64File(string $fileName, string $base64String): bool
    {
        return $this->storeFile($fileName, base64_decode($base64String));
    }
}
