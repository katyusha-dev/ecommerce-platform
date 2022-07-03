<?php

namespace Katyusha\Services\FaceId\FaceId;

use Cose\Algorithm\Manager as CoseAlgorithmManager;
use Cose\Algorithm\Signature;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use M1guelpf\FaceId\Utils\CredentialSource;
use Webauthn\AttestationStatement\AttestationObjectLoader;
use Webauthn\AttestationStatement\AttestationStatementSupportManager;
use Webauthn\AttestationStatement\NoneAttestationStatementSupport;
use Webauthn\AttestationStatement\PackedAttestationStatementSupport;
use Webauthn\AuthenticationExtensions\ExtensionOutputCheckerHandler;
use Webauthn\AuthenticatorAssertionResponseValidator;
use Webauthn\AuthenticatorAttestationResponseValidator;
use Webauthn\PublicKeyCredentialLoader;
use Webauthn\TokenBinding\IgnoreTokenBindingHandler;

class FaceIdServiceProvider extends ServiceProvider
{
    public const FASTLOGIN_COOKIE = 'X-FaceId';

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        Request::macro('hasCredential', fn () => $this->cookies->has(self::FASTLOGIN_COOKIE));
    }

    public function register(): void
    {
        $this->app->resolving(EncryptCookies::class, function ($object): void {
            $object->disableFor(self::FASTLOGIN_COOKIE);
        });

        $this->app->bind(CoseAlgorithmManager::class, static function () {
            return tap(new CoseAlgorithmManager(), function ($manager): void {
                array_map(fn ($algo) => $manager->add(new $algo()), [
                    Signature\ECDSA\ES256::class,
                    Signature\ECDSA\ES512::class,
                    Signature\EdDSA\EdDSA::class,
                    Signature\ECDSA\ES384::class,
                    Signature\EdDSA\Ed25519::class,
                    Signature\RSA\RS1::class,
                    Signature\RSA\RS256::class,
                    Signature\RSA\RS512::class,
                ]);
            });
        });

        $this->app->singleton(AttestationStatementSupportManager::class, static function ($app) {
            return tap(new AttestationStatementSupportManager(), function ($attestationStatementSupportManager) use ($app): void {
                $attestationStatementSupportManager->add(new NoneAttestationStatementSupport());
                $attestationStatementSupportManager->add(new PackedAttestationStatementSupport($app[CoseAlgorithmManager::class]));
            });
        });

        $this->app->singleton(AttestationObjectLoader::class, static function ($app) {
            return new AttestationObjectLoader(
                $app[AttestationStatementSupportManager::class],
                null,
                $app['log']
            );
        });

        $this->app->singleton(PublicKeyCredentialLoader::class, static function ($app) {
            return new PublicKeyCredentialLoader(
                $app[AttestationObjectLoader::class],
                $app['log']
            );
        });

        $this->app->bind(AuthenticatorAttestationResponseValidator::class, static function ($app) {
            return new AuthenticatorAttestationResponseValidator(
                $app[AttestationStatementSupportManager::class],
                new CredentialSource(),
                new IgnoreTokenBindingHandler(),
                new ExtensionOutputCheckerHandler(),
                null,
                $app['log']
            );
        });

        $this->app->bind(AuthenticatorAssertionResponseValidator::class, static function ($app) {
            return new AuthenticatorAssertionResponseValidator(
                new CredentialSource(),
                new IgnoreTokenBindingHandler(),
                new ExtensionOutputCheckerHandler(),
                $app[CoseAlgorithmManager::class],
                null,
                $app['log']
            );
        });
    }
}
