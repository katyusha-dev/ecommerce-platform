<?php

namespace Features\Traits;

use Mostafaznv\Larupload\LaruploadEnum;
use Mostafaznv\Larupload\Traits\Larupload;
use Mostafaznv\Larupload\Storage\Attachment;

trait VideoUploadTrait {
    use Larupload;

    public function attachments(): array {
        return [
            Attachment::make('video'),
            //            Attachment::make('other_file', LaruploadEnum::LIGHT_MODE),
        ];
    }

    public function uploadVideo(): bool {
//        $upload = new ;
//        $upload->main_file = $request->file('file');
//        $upload->save();
        return false;
    }
}
