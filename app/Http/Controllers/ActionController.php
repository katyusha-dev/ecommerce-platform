<?php

namespace App\Http\Controllers;

use Lorisleiva\Actions\AttributeValidator;
use Lorisleiva\Actions\Concerns\AsAction;

/**
 * @method static bool run(...$args)
 */
abstract class ActionController
{
    use AsAction;

    public function rules(): array
    {
        return [];
    }

    public function getControllerMiddleware(): array
    {
        return ['auth'];
    }

    public function authorize(): bool
    {
        return (bool) me();
    }

    public function withValidator(AttributeValidator $validator): void
    {
        $validator->validate();
    }

    public function success(): array
    {
        return ['success' => true];
    }
}
