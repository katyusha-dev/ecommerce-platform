<?php
/**
 * Created by PhpStorm.
 * User: Trafficfox
 * Date: 5/24/16
 * Time: 6:50 PM.
 */

namespace Trafficfox\Bring\API\Client;

use InvalidArgumentException;

/**
 * Class Credentials.
 */
class Credentials
{
    private $clientId;

    private $apiKey;

    private $clientUrl;

    /**
     * Creates bring credentials object.
     *
     * @param string $clientUrl Identifier ( your domain ).
     * @param string $clientId  Bring Client ID ( e.g. myuser@mydomain.no )
     * @param string $apiKey    ( e.g. xxxxxxxxxx-xxxx-xxxxx-xxxxx ) Get it from My Bring settings.
     */
    public function __construct(string $clientUrl, ?string $clientId = null, ?string $apiKey = null)
    {
        if (! $clientUrl) {
            throw new InvalidArgumentException('$clientUrl must not be empty.');
        }
        $this->clientId = $clientId;
        $this->apiKey = $apiKey;
        $this->clientUrl = $clientUrl;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getClientUrl(): string
    {
        return $this->clientUrl;
    }

    public function hasAuthorizationData()
    {
        return $this->clientId !== null && $this->apiKey !== null;
    }
}
