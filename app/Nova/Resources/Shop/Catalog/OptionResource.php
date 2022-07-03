<?php

namespace App\Nova\Resources\Shop\Catalog;

use App\Nova\Form;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Features\Catalog\Variables\Option;

class OptionResource extends Resource {
    public static $model   = Option::class;
    public static $group   = 'Catalog variations';

    public function fields(Request $request) {
        return Form::make($request)
            ->text('Name')
            ->bool('Is numeric')
            ->bool('Is clothing size')
            ->toArray();
    }
}
