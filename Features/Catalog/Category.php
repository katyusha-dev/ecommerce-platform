<?php

namespace Features\Catalog;

use Illuminate\Support\Facades\Storage;
use Features\Catalog\Models\CategoryModel;
use Illuminate\Contracts\Filesystem\Filesystem;

class Category extends CategoryModel {
    public function toArray(): array {
        $image                 = $this->getImageUrl();
        $array                 = parent::toArray();
        $array['slug']         = $this->namespace;
        $array['image']        = ['id' => mt_rand(11111111, 99999999), 'thumbnail' => $image, 'original' => $image];
        $array['productCount'] = $this->products()->count();

        return $array;
    }

    public function getImageUrl(): string {
        if (!$this->image) {
            return $this->products->first()->getImage();
        }

        return $this->getDisk()->url($this->image);
    }

    public function getDisk(): Filesystem {
        return Storage::disk('media');
    }
}
