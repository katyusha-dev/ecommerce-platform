<?php

namespace Katyusha\Services\FaceId\FaceId\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebAuthnCredential extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected string $table = 'webauthn_credentials';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'credId', 'key',
    ];
}
