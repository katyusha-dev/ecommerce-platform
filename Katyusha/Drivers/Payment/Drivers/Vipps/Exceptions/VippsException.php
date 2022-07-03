<?php

/**
 * Vipps exception.
 *
 * Provides and handles vipps exception.
 */

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions;

use function Drivers\Clients\Payments\Vipps\Exceptions\reset;
use Exception;
use JMS\Serializer\Serializer;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Error\AuthorizationError;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Error\ErrorInterface;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Error\PaymentError;
use Psr\Http\Message\ResponseInterface;

/**
 * Class VippsException.
 */
class VippsException extends Exception
{
    protected ?ErrorInterface $error;

    /**
     * VippsException constructor.
     */
    public function __construct(string $message = '', int $code = 0, ?Exception $previous = null, ?ErrorInterface $error = null)
    {
        parent::__construct($message, $code, $previous);
        $this->error = $error;
    }

    public function getError(): ?ErrorInterface
    {
        return $this->error;
    }

    /**
     * Create new Exception from Response.
     *
     * @return VippsException|null
     */
    public static function createFromResponse(
        ResponseInterface $response,
        ?Serializer $serializer = null,
        bool $force = true
    ): ?self {

        // If error code tells us that something went wrong we must accept it.
        if (! $force && $response->getStatusCode() >= 400) {
            $force = true;
        }

        $phrase = $response->getBody()->getContents();
        $phrase = self::parsePhrase($phrase, $serializer);

        // If not an instance of ErrorInterface we must assume everything is ok.
        if (! $force && ! ($phrase instanceof ErrorInterface)) {
            // Rewind content pointer.
            $response->getBody()->rewind();

            return null;
        }

        // If Error can be parsed.
        if ($phrase instanceof ErrorInterface) {
            return new static(
                $phrase->getMessage(),
                $response->getStatusCode(),
                null,
                $phrase
            );
        }

        // If Error cannot be parsed.
        return new static(
            $phrase ? $phrase : $response->getReasonPhrase(),
            $response->getStatusCode()
        );
    }

    protected static function parsePhrase(string $phrase, ?Serializer $serializer = null): object|array|int|float|string|bool
    {
        if (! ($serializer instanceof Serializer)) {
            return $phrase;
        }

        try {
            $decoded = json_decode($phrase, true);
            // Match AuthorizationError.
            if (isset($decoded['error'])) {
                return $serializer->deserialize(
                    $phrase,
                    AuthorizationError::class,
                    'json'
                );
            }
            // Match PaymentError collection.
            if (isset($decoded[0]['errorGroup'])) {
                $phrase = $serializer->deserialize(
                    $phrase,
                    'array<'.PaymentError::class.'>',
                    'json'
                );

                return reset($phrase);
            }
        } catch (Exception) {
            // Mute exceptions.
        }

        return $phrase;
    }
}
