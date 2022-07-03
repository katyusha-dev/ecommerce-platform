<?php

namespace App\Http\Controllers;

use Imagick;
use ErrorException;
use function config;
use function is_dir;
use ImagickException;
use function parse_url;
use function pathinfo;
use function preg_replace;
use function response;
use Features\Shop\Shop;
use function file_exists;
use Illuminate\Support\Str;
use Imagecow\Image as ImageCow;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use function str_replace;
use function strtok;

class CdnController extends Controller {
    public function serve(?string $namespace = '', ?string $file = '') {
        return $this->serveDirectly($file, $namespace);
    }

    public function handle(?string $namespace = '', ?string $file = '') {
//        $file = str_replace('&w', '?w', $file);
//        $url = parse_url($file);
//        parse_str($url['query'], $query);
//        $width = $query['w'] ?? null;
//        $file = $url['path'];

        foreach (config('cdn.do_not_handle') as $extension) {
            if (Str::contains($file, $extension)) {
                return $this->serveDirectly($file, $namespace);
            }
        }

//        return response()->file(Shop::cdnPath($namespace, $file));
        return $this->process($file, $namespace);
    }

    protected function serveDirectly(string $file, ?string $namespace = '') {
        return response()->file(Shop::cdnPath($namespace, $file));
    }

    /**
     * @throws ErrorException
     * @throws ImagickException
     */
    protected function process(string $file, ?string $namespace = '', ?int $width = 900, float $ratio = 1): BinaryFileResponse {
        $filePath      = Shop::cdnPath($namespace, $file);
        $fileName      = pathinfo($filePath, PATHINFO_BASENAME);
        $height        = $width * $ratio;
        $dir           = config('cdn.optimized_storage').'/'.$namespace;
        $optimizedFile = "${dir}/${fileName}.webp";

        if (!is_dir($dir)) {
            try {
                mkdir($dir);
            } catch (ErrorException) {
                throw new ErrorException("Failed to create directory ${dir}");
            }
        }


        if (file_exists($optimizedFile)) {
            return response()->file($optimizedFile);
        }


        $enhancedImg = new Imagick($filePath);
        $enhancedImg->enhanceImage();
        $enhancedImg->sigmoidalcontrastImage(true, 4, .5 * $enhancedImg->getQuantumRange()['quantumRangeLong']);
        $enhancedImg->writeImage($optimizedFile);

        ImageCow::fromFile($optimizedFile)
            ->resizeCrop($width, $height)
            ->quality(100)
            ->format('webp')
            ->save($optimizedFile);

        return response()->file($optimizedFile);
    }
}
