<?php

namespace Features\Shop;

use function request;
use Illuminate\Support\Str;
use Features\Shop\Models\ShopModel;
use Katyusha\Framework\UploaderTrait;
use Illuminate\Support\Facades\Storage;
use Features\Shop\Traits\ShopDataAccessors;
use Illuminate\Contracts\Filesystem\Filesystem;

class Shop extends ShopModel {
    use UploaderTrait;
    use ShopDataAccessors;

    public static function getByRequest(): static {
        return static::whereDomain(request()->getHost())->get()->first();
    }

    public function getDisk(): Filesystem {
        return Storage::disk('media');
    }

    public function getDiskBasePath(): string {
        return $this->namespace;
    }

    public function toArray() {
        $array                    = parent::toArray();
        $array['header_subtitle'] = nl2br($this->header_subtitle);
        $array['logo']            = $this->getLogoUrl();
        $array['header_image']    = $this->getHeaderImageUrl();

        return $array;
    }

    public function getHeaderImageUrl(): ?string {
        return $this->header_image ? $this->getDisk()->url($this->header_image) : null;
    }

    public function getLogoPath(): ?string {
        return $this->getDisk()->path($this->logo);
    }

    public function getLogoUrl(): ?string {
        return $this->getDisk()->url($this->logo);
    }

    public static function getFromRequest(): ?static {
        return static::where('namespace', 'birtelohne')->first();

        if (request()->get('namespace')) {
            return static::where('namespace', request()->get('namespace'))->first();
        }

        $domain = Str::replace(['https://', 'http://'], ['', ''], request()->header('Origin'));

        return static::where('domain', $domain)->first();
    }

    public static function mediaPath(string $namespace, ?string $file = null): string {
        return Storage::disk('media')->path($namespace.($file ? "/${file}" : ''));
    }

    public static function cdnPath(string $namespace, ?string $file = null): string {
        return Storage::disk('cdn')->path($namespace.($file ? "/${file}" : ''));
    }

    public function getUploadsUrl(): string {
        return $this->getDisk()->url($this->namespace);
    }
}
