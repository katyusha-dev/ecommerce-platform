<?php

namespace Katyusha\Framework\Eloquent;

use Exception;
use function serialize;
use Illuminate\Support\Str;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use Katyusha\Framework\Eloquent\ModelTraits\ReflectionHelper;
use Katyusha\Framework\Eloquent\BaseModelTraits\UuidHelperSaver;
use Katyusha\Framework\Eloquent\BaseModelTraits\ModelGetterTrait;
use Katyusha\Framework\Eloquent\BaseModelTraits\ModelSavingTrait;
use Katyusha\Framework\Eloquent\BaseModelTraits\ModelAttributeTrait;
use Katyusha\Framework\Eloquent\BaseModelTraits\ModelHelperMethodsTrait;

/**
 * Custom model which implements some helper functions to be used in different projects.
 *
 * @property string id
 * @property Carbon created_at
 *
 * @method static static|Builder query()
 * @method static static|Builder newQuery()
 * @method static static first()
 *
 * ********************** Boot methods
 * @method static void globalScopeQuery(Builder $builder)
 * @method void   bootAddGlobalScope(Builder $builder)
 *
 * @mixin Builder
 *
 * ********************** Model methods
 *
 * @method static static setAttribute(string $key, mixed $value)
 */
abstract class Model extends LaravelModel {
    use ReflectionHelper;
    use ModelMixins;
    use ModelGetterTrait;
    use ModelSavingTrait;
    use UuidHelperSaver;
    use ModelAttributeTrait;
    use ModelHelperMethodsTrait;
    use GeneratesUuid;
    public $incrementing        = false;
    public $uuidVersion         = 'uuid4';
    protected $hidden           = [];
    protected $keyType          = 'string';
    protected array $checkUuids = [];
    protected $appends          = [];
    protected array $intCasts   = [];
    protected array $floatCasts = [];

    public static function boot(): void {
        parent::boot();
    }

    public static function createUniqueNumericId(): int {
        return time() + (getmypid() * mt_rand(0, getmypid()));
    }

    public function getNumericId(): int {
        return $this->numeric_id;
    }

    /**
     * @throws Exception
     */
    public function validateInputTypes(): void {
        if ($this->id && !Str::isUuid($this->id)) {
            throw new Exception('ID is expected to be UUID, but got: '.serialize($this->id));
        }

        if ($this->checkUuids) {
            foreach ($this->checkUuids as $key) {
                if ($this->{$key} && !Str::isUuid($this->{$key})) {
                    throw new Exception("Input mismatch on key [${key}] expected [uuid] value [".$this->{$key}.']');
                }
            }
        }
    }

    public function uuidColumn(): string {
        return 'id';
    }

    public static function _getTable(): string {
        return (new static())->table;
    }

    public static function make(): static {
        return new static();
    }

    public function newEloquentBuilder($query) {
        return new Builder($query);
    }

    public function newCollection(array $models = []): mixed {
        return new Collection($models);
    }

    public function newBuilder($query): Builder {
        return new Builder($query);
    }

    public function getAppends(): array {
        return $this->appends;
    }

    public function getCasts() {
        $casts = $this->casts;
        foreach ($this->intCasts as $item) {
            $casts[$item] = 'int';
        }
        foreach ($this->floatCasts as $item) {
            $casts[$item] = 'float';
        }

        return $casts;
    }
}
