<?php

namespace Katyusha\Framework\Utils;

use Carbon\Carbon;
use function unlink;

/**
 * Class File.
 *
 * @property string path
 * @property string name
 * @property string extension
 */
class File
{
    public function __construct()
    {
    }

    public static function nameTimestamp(): string
    {
        return str_replace([' ', ':'], ['_', '-'], Carbon::now()->toDateTimeString());
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return File
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return File
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return File
     */
    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public static function sendToBrowser(string $path, bool $alsoDelete = false): void
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize($path));
        ob_clean();
        flush();
        readfile($path);

        if ($alsoDelete) {
            unlink($path);
        }
        exit;
    }
}
