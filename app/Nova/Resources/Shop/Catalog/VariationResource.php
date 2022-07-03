<?php

namespace App\Nova\Resources\Shop\Catalog;

use App\Nova\Form;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Features\Catalog\Variables\Variation;

class VariationResource extends Resource {
    public static $model   = Variation::class;
    public static $group   = 'Catalog variations';

    public function fields(Request $request) {
        return Form::make($request)
            ->text('Sku')
            ->integer('Price')
            ->integer('Sale Price')
            ->belongsTo('Product', ProductResource::class, false)
            ->belongsToMany('Option', OptionResource::class, false, 'options')
            ->belongsToMany('Option Value', OptionValueResource::class, false, 'optionValues')
            ->toArray();
    }
}
