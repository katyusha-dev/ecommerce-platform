<?php

namespace App\Nova\Resources\Shop\Catalog;

use App\Nova\Form;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Features\Catalog\Category;
use PixelCreation\NovaFieldSortable\Concerns\SortsIndexEntries;

class CategoryResource extends Resource {
    use SortsIndexEntries;

    public static $model   = Category::class;
    public static $group   = 'Catalog';

    public function fields(Request $request) {
        $form = Form::make($request)
            ->text('Name')
            ->icon('Icon')
            ->sortable()
            ->belongsTo('Parent', static::class, true);

        return $form->toArray();
    }
}
