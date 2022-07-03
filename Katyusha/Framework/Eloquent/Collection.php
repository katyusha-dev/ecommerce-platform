<?php

namespace Katyusha\Framework\Eloquent;

use Illuminate\Database\Eloquent\Collection as LaravelCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as SupportCollection;

class Collection extends LaravelCollection
{
    use CollectionMixins;

    public function addMultiple(mixed ...$items): static
    {
        foreach ($items as $item) {
            $this->add($item);
        }

        return $this;
    }

    /**
     * Performs a function on the items of the collection, and returns a new collection.
     */
    public function performMethodOnItems($method): static
    {
        $collection = new static();
        $this->map(fn ($item) => $collection->add($method($item)));

        return $collection->removeNullValues();
    }

    public function removeNullValues(): self
    {
        return $this->filter(fn ($value) => ! is_null($value));
    }

    /**
     * Casts the items of a collection onto another class.
     */
    public function castTo(string $collectionClass): mixed
    {
        /** @var self $collection */
        $collection = new $collectionClass();
        $this->map(fn ($item) => $collection->add($item));

        return $collection;
    }

    /**
     * Casts the entire collection onto another class.
     */
    public function toClass(string $class)
    {
        return new $class($this);
    }

    public function sortAlphabeticallyByKey(): self
    {
        return $this->sortBy(fn (SupportCollection $collection, string $key) => (string) $key, SORT_NATURAL | SORT_FLAG_CASE, false);
    }

    public function flatten($depth = 1)
    {
        return new $this(Arr::flatten($this->items, $depth));
    }

    /**
     * This will extract a key of a child item, such as "product",
     * set it within the main object, and remove the key.
     */
    public function extractAndFlatten(string $keyName, ?string $alias = null): self
    {
        $items = [];

        foreach ($this->toArray() as $item) {
            if (is_array($item[$keyName])) {
                foreach ($item[$keyName] as $k => $v) {
                    $newKey = ($alias ? $alias : $keyName).'_'.$k;
                    $item[$newKey] = $v;
                }
            }

            unset($item[$keyName]);
            $items[] = $item;
        }

        return static::make($items);
    }
}
