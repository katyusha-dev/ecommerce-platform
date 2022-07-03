<?php

namespace App\Nova\Resources\Shop\Catalog;

use App\Nova\Form;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Features\Catalog\CatalogCollection;

class CatalogCollectionResource extends Resource {
    public static $model   = CatalogCollection::class;
    public static $group   = 'Catalog';

    public function fields(Request $request) {
        return Form::make($request)
            ->text('Name')
            ->text('Title')
            ->textarea('Description')
            ->belongsToMany('Products', ProductResource::class)
            ->image('Image')
            ->toArray();
    }
}
