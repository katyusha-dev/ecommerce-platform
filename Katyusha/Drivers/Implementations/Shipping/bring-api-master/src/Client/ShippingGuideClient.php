<?php

namespace Trafficfox\Bring\API\Client;

use Trafficfox\Bring\API\Contract\ShippingGuide\PriceRequest;

/**
 * Class ShippingGuideClient.
 *
 * @todo We can implement My bring credentials for shipping guide requests once Bring has fixed the API to work with RESTFUL and not SOAP. See http://developer.bring.com/api/shipping-guide/
 */
class ShippingGuideClient extends Client
{
    public const BRING_PRICES_API = 'https://api.bring.com/shippingguide/v2/products';

    protected $_apiBringPrices = self::BRING_PRICES_API;

    public function getPrices(PriceRequest $request)
    {
        $query = $request->toArray();

        $url = $this->_apiBringPrices;

        $options = [
            'query' => $this->getQueryParams($query),
        ];

        try {
            $request = $this->request('get', $url, $options);
            return json_decode($request->getBody(), true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            throw new ShippingGuideClientException('Could not retrieve prices.', null, $e);
        }
    }

    public function setBringPricesApi($api)
    {
        $this->_apiBringPrices = $api;

        return $this;
    }
}
