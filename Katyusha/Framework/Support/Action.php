<?php

namespace Katyusha\Framework\Support;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\AttributeValidator;
use Lorisleiva\Actions\Concerns\AsAction;
use Throwable;

/**
 * @method static bool run()
 */
abstract class Action
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

    public function authorize(ActionRequest $request): bool
    {
        return (bool) me();
    }

    public function withValidator(AttributeValidator $validator, ActionRequest $request): void
    {
        $validator->validate();
    }

    public function success(): array
    {
        return ['success' => true];
    }

    protected function failed(Throwable $exception): array
    {
        return ['success' => false, 'message' => $exception->getMessage()];
    }
}
