<?php

namespace App\Nova\Resources\Shop\Catalog;

use App\Nova\Form;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Features\Catalog\Product;

class ProductResource extends Resource {
    public static $model   = Product::class;
    public static $group   = 'Catalog';

    public function fields(Request $request) {
        $form = Form::make($request)
            ->bool('Featured')
            ->bool('Hidden')
            ->text('Name')
            ->image('Image')
            ->gallery('Gallery')
            ->text('Sku')
            ->textarea('Description')
            ->textarea('Product Grid Description')
            ->money('Price')
            ->money('Sale Price')
            ->belongsToMany('Categories', CategoryResource::class)
            ->belongsToMany('Options', OptionResource::class);

        return $form->toArray();
    }
}
