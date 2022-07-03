<?php

namespace Trafficfox\Bring\API\Contract\Tracking;

use InvalidArgumentException;
use Trafficfox\Bring\API\Contract\ApiEntity;
use Trafficfox\Bring\API\Contract\ContractValidationException;

class TrackingRequest extends ApiEntity
{
    protected $_data = [
        'q' => null,
        'lang' => null,
    ];
    private static $_LANGUAGES = ['no', 'en', 'sv', 'da'];

    /**
     * Searches for given query.
     *
     * @param $query Reference, package number, shipment number to search for
     *
     * @return $this
     */
    public function setQuery($query)
    {
        return $this->setData('q', $query);
    }

    public function setLanguage($language)
    {
        if (! in_array($language, self::$_LANGUAGES)) {
            throw new InvalidArgumentException("Invalid language '${language}'. Valid languages are: ".implode(', ', self::$_LANGUAGES));
        }

        return $this->setData('lang', $language);
    }

    public function validate(): void
    {
        if (! $this->getData('q')) {
            throw new ContractValidationException('TrackingRequest requires "q" attribute to be set.');
        }
    }
}
