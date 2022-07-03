<?php

namespace App\Nova\Resources\Admin\Clients;

use App\Nova\Form;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Features\Client\Contacts;

class ContactResource extends Resource {
    public static $model   = Contacts::class;
    public static $group   = 'CRM';

    public function fields(Request $request) {
        $form = Form::make($request)
            ->text('First Name')
            ->text('Last Name')
            ->email('Email')
            ->integer('Mobile')
            ->text('Position')
            ->bool('Is Decision Maker')
            ->belongsTo('Client', ClientResource::class);

        return $form->toArray();
    }
}
