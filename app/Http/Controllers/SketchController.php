<?php

namespace App\Http\Controllers;

use App\Models\User;
use Features\Shop\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use Katyusha\Framework\Eloquent\Model;
use stdClass;
use Throwable;

/**
 * Sketches are simple actions which do not do very much.
 * They can be useful, but to be thought more of as a controller method.
 *
 * @order 99
 */
class SketchController
{
    protected User $user;
    protected Shop $shop;
    protected array $options = [];
    protected bool $productOptions = false;
    protected bool $orderOptions = false;
    protected bool $categoryOptions = false;
    protected ?Request $request;

    /**
     * Sketch constructor.
     *
     * @throws SketchException
     */
    public function __construct()
    {
        $this->request = request();
        $user = me();
        $shop = $user->shop;

        if (! $user) {
            throw new SketchException('No user');
        }

        if (! $shop) {
            throw new SketchException('No shop');
        }

        $this->user = $user;
        $this->shop = $shop;
    }

    public function json(array|object $data): JsonResponse
    {
        return response()->json($data);
    }

    public function dd(mixed $data): void
    {
        dd($data);
    }

    public function send(array | object $data): array | object
    {
        if ($data instanceof Model) {
            $data = $data->toArray();
        }

        if (is_array($data)) {
            return json_decode(json_encode($data));
        }

        dd($data);
    }

    public function addOption(string $key, array $values): static
    {
        $this->options[$key] = $values;

        return $this;
    }

    public function getOptions(): array
    {
        if ($this->productOptions) {
            $this->addOption('productId', $this->shop->products()->get()->pluck('id', 'name')->toArray());
        }

        if ($this->orderOptions) {
            $this->addOption('orderId', $this->shop->orders()->where('shop_id', $this->shop->getId())->where('profile_id', '<>', null)->get()->pluck('id', 'numeric_id')->toArray());
        }

        return $this->options;
    }

    public function pre(string $output, string $language = 'text'): void
    {
        echo "<pre class='code ${language}'>${output}</pre>";
    }

    public function tryCatch(callable $method): void
    {
    }

    public function throw(Throwable $e): void
    {
    }

    #[ArrayShape(['message' => 'string'])]
 public function success(stdClass | array|null $data = null): array
 {
     return ['message' => 'success'];
 }

    #[ArrayShape(['message' => 'string'])]
 public function error(stdClass | array|null $data = null): array
 {
     return ['message' => 'error'];
 }
}
