<?php

namespace Katyusha\Framework\Utils;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use mysql_xdevapi\Exception;

class Filesystem
{
    public $disk;
    public $allowedExtensions = ['svg', 'png', 'jpg', 'jpeg', 'ico'];

    public function __construct(string $diskName)
    {
        $this->disk = Storage::disk($diskName);
    }

    public static function ensureExternalFileExists(string $url): ?string
    {
        if (! $url) {
            return null;
        }

        if (self::checkExternalFile($url)) {
            return $url;
        }

        $test = str_replace(' ', '%20', $url);

        if (self::checkExternalFile($test)) {
            return $test;
        }

        $parsedURL = parse_url($url);

        if (! isset($parsedURL['host'])) {
            return '';
        }
        $test = $parsedURL['scheme'].'://'.$parsedURL['host'].str_replace('%2F', '/', urlencode($parsedURL['path']));

        if (self::checkExternalFile($test)) {
            return $test;
        }

        return null;
    }

    public static function checkExternalFile(string $url): bool
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $code === 200;
    }

    public static function storeInDisk(string $diskName, string $filePath, string $originalName): string
    {
        $pathInfo = pathinfo($originalName);

        if (! $pathInfo['extension']) {
            throw new Exception('File type not supported');
        }
        $newName = md5(microtime()).'.'.$pathInfo['extension'];
        move_uploaded_file($filePath, Storage::disk($diskName)->path($newName));

        return $newName;
    }

    public function get($path)
    {
        return $this->disk->get($path);
    }

    public function getExcel($path, ToModel $toModel): void
    {
        $contents = $this->disk->get($path);
    }

    public function getObject($path): void
    {
        $contents = $this->disk->get($path);
        $boom = \explode('.', $path);
        $ext = \end($boom);
    }

    public function isExcel($path)
    {
        $boom = \explode('.', $path);

        return \in_array(\end($boom), ['xls', 'xlsx'], true);
    }

    public function store($dest, $content): void
    {
        $this->disk->put($dest, $content);
    }

    public static function checkRemoteFileAvailability($url)
    {
        $url = self::cleanUrl($url);

        if (! $url) {
            return false;
        }
        $ch = \curl_init($url);
//        return file_get_contents($url,0,null,0,1);\curl_setopt($ch, \CURLOPT_NOBODY, true);
        \curl_exec($ch);
        $retcode = \curl_getinfo($ch, \CURLINFO_HTTP_CODE);
        \curl_close($ch);

        return $retcode === 200;
    }

    public static function cleanUrl($url)
    {
        $parsed = \parse_url($url);

        if (! $parsed || ! isset($parsed['scheme'])) {
            return false;
        }

        return $parsed['scheme'].'://'.$parsed['host'].\str_replace('%2F', '/', \rawurlencode($parsed['path']));
    }

    public static function downloadAndStore($source, $dest, $public = false)
    {
        $source = self::cleanUrl($source);

        if (! $source) {
            return false;
        }
        $boom = \explode('/', $dest);
        $name = \end($boom);
        $data = \file_get_contents($source);

        if (! \mb_strlen($data)) {
            return false;
        }
        $visibility = $public ? 'public' : 'private';

        return Storage::disk(self::$diskName_static)->put($dest, $data, ['visibility' => $visibility]);
    }
}
