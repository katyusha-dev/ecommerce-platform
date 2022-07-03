<?php

namespace App\Models;

use Carbon\Carbon;
use Features\Shop\Shop;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Auth\Impersonatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property Shop shop
 */
class User extends Authenticatable {
    use Notifiable;
    use GeneratesUuid;
//    use Impersonatable;

    public $incrementing = false;
    public $uuidVersion  = 'uuid4';
    protected $keyType   = 'string';

    protected $dateFormat = 'Y-m-d H:i:s.u';

//    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_active', 'shop_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//    public function tokens() {
//        return $this->morphMany(Sanctum::$personalAccessTokenModel, 'tokenable', 'tokenable_type', 'tokenable_id');
//    }

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function uuidColumn(): string {
        return 'id';
    }

    public function getCreatedAtAttribute() {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s.u');
    }

    public static function boot(): void {
        parent::boot();
        // Order by updated_at desc
        static::addGlobalScope('order', function (Builder $builder): void {
            $builder->orderBy('updated_at', 'desc');
        });
    }

    public static function me(): self|null {
        return Auth::user();
    }

    public function getShopId(): ?string {
        return $this->shop_id;
    }

    public function isAdmin(): bool {
        return $this->is_admin;
    }

    public function shop(): BelongsTo {
        return $this->belongsTo(Shop::class);
    }
}
