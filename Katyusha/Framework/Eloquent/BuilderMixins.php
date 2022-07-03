<?php

namespace Katyusha\Framework\Eloquent;

use App\Data\Eloquent\AppBuilder;
use App\Data\Eloquent\AppModel;
use Closure;
use Illuminate\Eloquent\Relations\BelongsToMany;
use Illuminate\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 ******************** Query/Eloquent.
 *
 ******************** Relations
 *
 * @method AppBuilder|BelongsToMany belongsToMany($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null, $parentKey = null, $relatedKey = null, $relation = null)
 * @method AppBuilder|HasMany       hasMany($related, $foreignKey = null, $localKey = null)
 ******************** Others
 * @method Collection           unique($key = null, $strict = false)
 * @method static               static newModelQuery()
 * @method static               static newQuery()
 * @method static               static wherePivot()
 * @method static               static orderBy(string $column, string $direction = 'asc')
 * @method static               static whereUuid(string $uuid, ?string $uuidColumn = null)
 * @method static               static with(string|array $relation, Closure $callback = NULL)
 * @method static               static where(string|Closure $column, ?string $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static               static whereHas(string $relation, Closure $callback = null, string $operator = '>=', int $count = 1)
 * @method static               static|null $this find($id, $columns = ['*'])                                                                Find a model by its primary key.
 * @method static               firstOrFail(array $columns = ['*'])                                                                          Execute the query and get the first result or throw an exception.
 * @method static               AppModel|mixed sole(array $columns = ['*'])                                                                  Execute the query and get the first result or throw an exception.
 * @method static               AppModel|mixed first(array $columns = ['*'])                                                                 Execute the query and get the first result or throw an exception.
 * @method mixed                value(string $column)                                                                                        Get a single column's value from the first result of a query.
 * @method void                 chunk(int $count, callable $callback)                                                                        Chunk the results of the query.
 * @method LengthAwarePaginator paginate(?int $perPage = null, array $columns = ['*'], string $pageName = 'page', mixed $page = null)        Paginate the given query.
 * @method Paginator            simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page')                                        Paginate the given query into a simple paginator.
 * @method int                  increment($column, $amount = 1, array $extra = [])                                                           Increment a column's value by a given amount.
 * @method int                  decrement($column, $amount = 1, array $extra = [])                                                           Decrement a column's value by a given amount.
 * @method void                 onDelete(Closure $callback)                                                                                  Register a replacement for the default delete function.
 * @method static[]             getModels($columns = ['*'])                                                                                  Get the hydrated models without eager loading.
 * @method array                eagerLoadRelations(array $models)                                                                            Eager load the relationships for the models.
 * @method array                loadRelation(array $models, $name, Closure $constraints)                                                     Eagerly load the relationship on a set of models.
 * @method static               static orWhere($column, $operator = null, $value = null)                                                     Add an "or where" clause to the query.
 * @method static               has($relation, $operator = '>=', $count = 1, $boolean = 'and', Closure $callback = null)                     Add a relationship count condition to the query.
 * @method static               static create($value)
 * @method static               static find($value)
 * @method static               static select($columns = ['*'])
 * @method static               static whereRaw($sql, array $bindings = [])
 * @method static               static whereBetween($column, array $values)
 * @method static               static whereNotBetween($column, array $values)
 * @method static               static whereNested(Closure $callback)
 * @method static               static when(mixed $condition, Closure $callback)
 * @method static               static addNestedWhereQuery($query)
 * @method static               static whereExists(Closure $callback)
 * @method static               static whereNotExists(Closure $callback)
 * @method static               static whereIn($column, $values)
 * @method static               static groupBy($column)
 * @method static               static whereNotIn($column, $values)
 * @method static               static whereNull($column)
 * @method static               static whereNotNull($column)
 * @method static               static orWhereRaw($sql, array $bindings = [])
 * @method static               static orWhereBetween($column, array $values)
 * @method static               static orWhereNotBetween($column, array $values)
 * @method static               static orWhereExists(Closure $callback)
 * @method static               static orWhereNotExists(Closure $callback)
 * @method static               static orWhereIn($column, $values)
 * @method static               static orWhereNotIn($column, $values)
 * @method static               static orWhereNull($column)
 * @method static               static orWhereNotNull($column)
 * @method static               static whereDate($column, $operator, $value)
 * @method static               static whereDay($column, $operator, $value)
 * @method static               static whereMonth($column, $operator, $value)
 * @method static               static whereYear($column, $operator, $value)
 */
trait BuilderMixins
{
}
