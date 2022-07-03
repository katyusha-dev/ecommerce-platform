<?php

namespace Katyusha\Framework\Eloquent\ModelTraits;

use Illuminate\Support\Str;
use Katyusha\Framework\Eloquent\Model;

/**
 * Entity-based models is when the system is setup that the models are abstracted in a sense,
 * and there are entities which extend these models and has more methods implemented on them.
 *
 * @mixin Model
 */
trait EntityBasedModels {
    public static function entityClass(): ?string {
        return null;
    }

    public static function entityClassInstance(): ?Model {
        if ($cls = static::entityClass()) {
            return new $cls();
        }

        return null;
    }

    public static function entityObject(): object {
        return new static::entityClass();
    }

    /**
     * Casts the model instance into the abstracted entity of it.
     */
    public function castToEntity(): mixed {
        return static::entityObject()::getItem($this->getId());
    }

    /**
     * Get the parent model of an entity class.
     */
    public static function getParentModel(): static | self | null {
        $model = static::getParentClass();

        if ($model === self::class || ! Str::contains($model, 'Model')) {
            $model = null;
        }

        return $model ? new $model() : null;
    }
}
