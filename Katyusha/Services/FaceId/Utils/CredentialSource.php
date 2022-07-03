<?php

namespace Katyusha\Services\FaceId\FaceId\Utils;

use Illuminate\Support\Str;
use M1guelpf\FaceId\Models\WebAuthnCredential;
use Webauthn\PublicKeyCredentialSource;
use Webauthn\PublicKeyCredentialSourceRepository;
use Webauthn\PublicKeyCredentialUserEntity;
use Webauthn\TrustPath\EmptyTrustPath;

class CredentialSource implements PublicKeyCredentialSourceRepository
{
    public function findOneByCredentialId(string $publicKeyCredentialId): ?PublicKeyCredentialSource
    {
        $credential = WebAuthnCredential::where('credId', $publicKeyCredentialId)->first();

        return is_null($credential) ? $credential : new PublicKeyCredentialSource(
            $credential['credId'],
            'public-key',
            ['internal'],
            'none',
            new EmptyTrustPath(),
            Str::uuid(),
            $credential['key'],
            $credential->user_id,
            0,
        );
    }

    public function findAllForUserEntity(PublicKeyCredentialUserEntity $publicKeyCredentialUserEntity): array
    {
        return []; // Not Implemented
    }

    public function saveCredentialSource(PublicKeyCredentialSource $publicKeyCredentialSource): void
    {
        // Not Implemented
    }
}
