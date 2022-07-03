<?php

namespace App\Nova\Resources\Admin\Clients;

use App\Nova\Form;
use App\Nova\Resource;
use Features\Client\Client;
use Illuminate\Http\Request;

class ClientResource extends Resource {
    public static $model   = Client::class;
    public static $group   = 'CRM';

    public function fields(Request $request) {
        $form = Form::make($request)
            ->text('Name')
            ->email('Contact Email')
            ->bool('Active Customer')
            ->hasMany('Contacts', ContactResource::class);

        return $form->toArray();
    }
}
