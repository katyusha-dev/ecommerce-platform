<?php

namespace Features\Request;

use Features\Shop\Shop;
use Illuminate\Http\Request;

class SsrPageContext
{
    protected array $context = [];

    public function __construct(protected Request $request)
    {
        $this->setupContextData();
    }

    public function add(string $key, mixed $value): self
    {
        $this->context[$key] = $value;

        return $this;
    }

    public function get(): array
    {
//        dd($this->context['pages']);

        return $this->context;
    }

    private function setupContextData(): void
    {
        $shop = Shop::getFromRequest();
        $this->add('shop', $shop)
            ->add('categories', $shop->categories)
            ->add('pages', $shop->pages->toArray())
            ->add('products', $shop->products->toArray())
            ->add('collections', $shop->collections->toArray());
    }
}
