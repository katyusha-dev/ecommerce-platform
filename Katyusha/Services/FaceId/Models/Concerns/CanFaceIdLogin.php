<?php

namespace Katyusha\Services\FaceId\FaceId\Models\Concerns;

use M1guelpf\FaceId\Models\WebAuthnCredential;

trait CanFaceId
{
    public function webauthnCredentials()
    {
        return $this->hasMany(WebAuthnCredential::class);
    }
}
