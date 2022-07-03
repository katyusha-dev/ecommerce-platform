<?php

namespace Katyusha\Framework\Storage;

use Illuminate\Support\Facades\Storage;

trait UsesDisk
{
    abstract public static function getDiskName(): string;

    protected function getAttributeDiskUrl(string $attribute, ?int $size = null): ?string
    {
        $size = $size ? $size : '';
        $attr = $this->getAttribute($attribute);
        $name = str_replace('//', '/', $size.'/'.$attr);

        return $this->getAttribute($attribute) ? Storage::disk(self::getDiskName())->url($name) : null;
    }
}
