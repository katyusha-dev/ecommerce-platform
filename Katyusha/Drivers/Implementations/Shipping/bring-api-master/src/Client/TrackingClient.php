<?php

namespace Trafficfox\Bring\API\Client;

use Trafficfox\Bring\API\Contract\Tracking\TrackingRequest;

class TrackingClient extends Client
{
    public const BRING_TRACKING = 'https://tracking.bring.com/tracking.json';

    public const MYBRING_TRACKING = 'https://www.mybring.com/tracking/api/tracking.json';

    protected $_apiTracking = self::BRING_TRACKING;

    protected $_apiMybringTracking = self::MYBRING_TRACKING;

    public function getTracking(TrackingRequest $request)
    {
        $query = $request->toArray();

        $url = $this->getTrackingApiUrl();

        $options = [
            'query' => $this->getQueryParams($query),
        ];

        try {
            $request = $this->request('get', $url, $options);
            return json_decode($request->getBody(), true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            throw new TrackingClientException('Could not track package.', null, $e);
        }
    }

    public function setApiTracknig($url)
    {
        $this->_apiTracking = $url;

        return $this;
    }

    public function setApiMybringTracking($url)
    {
        $this->_apiMybringTracking = $url;

        return $this;
    }

    protected function getTrackingApiUrl()
    {
        return $this->_credentials->hasAuthorizationData() ? $this->_apiMybringTracking : $this->_apiTracking;
    }
}
