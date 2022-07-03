<?php

namespace App\Nova\Resources\Shop\Catalog;

use App\Nova\Form;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Features\Catalog\Addons\Addon;

class AddonResource extends Resource {
    public static $model   = Addon::class;
    public static $group   = 'Catalog alternatives';

    public function fields(Request $request) {
        return Form::make($request)
            ->text('Name')
            ->hasMany('Options', AddonOptionResource::class)
            ->belongsToMany('Apply to the following products', ProductResource::class, true, 'products')
            ->belongsToMany('Apply to the following categories', CategoryResource::class, true, 'categories')
            ->toArray();
    }
}
