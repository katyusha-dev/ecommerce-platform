<?php

namespace App\Nova\Resources\Admin\Media;

use App\Nova\Form;
use App\Nova\Resource;
use Features\Media\Video;
use Illuminate\Http\Request;

class VideoResource extends Resource {
    public static $model   = Video::class;
    public static $group   = 'Shops';

    public function fields(Request $request) {
        return Form::make($request)
            ->text('Name')
            ->file('Ogv', 'video')
            ->file('Webm', 'video')
            ->file('Mp4', 'video')
            ->toArray();
    }
}
