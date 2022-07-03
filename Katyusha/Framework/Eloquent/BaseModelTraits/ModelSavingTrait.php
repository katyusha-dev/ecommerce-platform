<?php

namespace Katyusha\Framework\Eloquent\BaseModelTraits;

trait ModelSavingTrait
{
    public function saveWithoutEvents(): mixed
    {
        return static::withoutEvents(fn () => $this->save());
    }

    /**
     * @return $this
     */
    public function saveAndReturnModel()
    {
        $this->save();

        return $this;
    }

    /**
     * @return $this
     */
    public function saveAndReturnModelWithoutEvents()
    {
        $this->saveWithoutEvents();

        return $this;
    }
}
