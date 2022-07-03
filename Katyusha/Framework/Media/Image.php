<?php

namespace Katyusha\Framework\Media;

use Exception;
use Imagick;
use ImagickException;

class Image
{
    public function __construct(protected string $path)
    {
    }

    public function getAverageColor(bool $as_hex_string = true)
    {
        try {
            // Read image file with Image Magick
            $image = new Imagick($this->path);
            // Scale down to 1x1 pixel to make Imagick do the average
            $image->scaleimage(1, 1);
            /** @var ImagickPixel $pixel */
            if (! $pixels = $image->getimagehistogram()) {
                return null;
            }
        } catch (ImagickException $e) {
            // Image Magick Error!
            return null;
        } catch (Exception $e) {
            // Unknown Error!
            return null;
        }

        $pixel = reset($pixels);
        $rgb = $pixel->getcolor();

        if ($as_hex_string) {
            return sprintf('%02X%02X%02X', $rgb['r'], $rgb['g'], $rgb['b']);
        }

        return $rgb;
    }
}
