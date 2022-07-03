<?php

namespace Features\Catalog;

use function config;
use Katyusha\Framework\Media\Image;
use Katyusha\Framework\UploaderTrait;
use Features\Catalog\Models\ProductModel;
use Illuminate\Contracts\Filesystem\Filesystem;

class Product extends ProductModel {
    use UploaderTrait;

    public function getDisk(): Filesystem {
        return $this->shop->getDisk();
    }

    public function getDiskBasePath(): string {
        return $this->shop->getDiskBasePath();
    }

    public function getProductType(): string {
        return 'simple';
    }

    public function deactivate(): static {
        $this->setActive(false)->save();

        return $this;
    }

    public function getImage(): ?string {
        return config('cdn.url.cdn').'/'.$this->image;
    }

    public function getThumbnail(): ?string {
        return config('cdn.url.cdn').'/'.$this->image;
    }

    public function toArray() {
        $array                 = parent::toArray();
        $image                 = config('cdn.url.cdn').'/'.$this->image;
        $array['image']        = ['id' => mt_rand(11111111, 99999999), 'thumbnail' => $image, 'original' => $image];
        $array['slug']         = $this->namespace;

        return $array;
    }

    public function thumbnail(): Image {
        return new Image(storage_path('media/'.$this->image));
    }
}
