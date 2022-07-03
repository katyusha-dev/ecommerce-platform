<?php

namespace App\Nova\Resources\Shop\Catalog;

use App\Nova\Form;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Features\Catalog\Variables\OptionValue;

class OptionValueResource extends Resource {
    public static $model   = OptionValue::class;
    public static $group   = 'Catalog variations';

    public function fields(Request $request) {
        return Form::make($request)
            ->text('Name')
            ->belongsTo('Option', OptionResource::class)
            ->toArray();
    }
}
