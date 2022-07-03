<?php

namespace App\Nova\Resources\Shop\Catalog;

use App\Nova\Form;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Features\Catalog\Addons\AddonOption;

class AddonOptionResource extends Resource {
    public static $model   = AddonOption::class;
    public static $group   = 'Catalog alternatives';

    public function fields(Request $request) {
        $form = Form::make($request)
            ->belongsTo('Addon', AddonResource::class)
            ->money('Price')
            ->text('Name');

        return $form->toArray();
    }
}
