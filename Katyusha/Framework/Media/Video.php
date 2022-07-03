<?php

namespace Katyusha\Framework\Media;

use function env;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use function storage_path;

class Video
{
    public const GIF_LENGTH = 60;
    public const GIF_SHORT_LENGTH = 20;
    protected string $baseDir;
    protected string $conversionsDir;
    protected string $url;
    protected int $length;
    protected Filesystem $disk;

    public function __construct(protected string $fileName)
    {
        $this->baseDir = storage_path("video/${fileName}");
        $this->conversionsDir = storage_path("video_conversions/${fileName}");
        $this->url = env('VIDEO_CDN_URL').'/'.$this->fileName;
        $this->disk = Storage::disk('video_conversions');
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
        ];
    }

    protected function gifLength(VideoConversionTypes $type): int
    {
        return match ($type) {
            VideoConversionTypes::GIF => self::GIF_LENGTH,
            VideoConversionTypes::GIF_SHORT => self::GIF_SHORT_LENGTH,
            default => $this->length,
        };
    }
}
