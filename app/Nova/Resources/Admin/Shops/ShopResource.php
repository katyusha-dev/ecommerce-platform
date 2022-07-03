<?php

namespace App\Nova\Resources\Admin\Shops;

use App\Nova\Form;
use App\Nova\Resource;
use Features\Shop\Shop;
use Illuminate\Http\Request;
use App\Nova\Resources\Admin\Media\VideoResource;
use App\Nova\Resources\Admin\Clients\ClientResource;

class ShopResource extends Resource {
    public static $model   = Shop::class;
    public static $group   = 'Shops';

    public function fields(Request $request) {
        $form = Form::make($request)
            ->text('Name')
            ->text('Domain')
            ->text('Email')
            ->text('Address')
            ->text('Sms From')
            ->text('City')
            ->integer('Zip')
            ->file('Logo')
            ->text('Wc Consumer Key')
            ->url('Wc Url')
            ->belongsTo('Client', ClientResource::class)
            ->belongsTo('Video', VideoResource::class, true);

        return $form->toArray();
    }
}
