<?php

namespace Trafficfox\Bring\API\Client;

use Trafficfox\Bring\API\Contract\Booking\BookingRequest;

class BookingClient extends Client
{
    public const BRING_CUSTOMERS_API = 'https://api.bring.com/booking/api/customers.json';

    public const BRING_BOOKING_API = 'https://api.bring.com/booking/api/booking';

    protected $_apiBringCustomers = self::BRING_CUSTOMERS_API;

    protected $_apiBringBooking = self::BRING_BOOKING_API;

    private $_customersCache = [];

    public function getCustomers($getFromCache = true)
    {
        if ($this->_customersCache && $getFromCache) {
            return $this->_customersCache;
        }

        try {
            $request = $this->request('get', $this->_apiBringCustomers);
            $json = json_decode($request->getBody(), true);
            $this->_customersCache = $json['customers'];

            return $this->_customersCache;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            throw new BookingClientException('Could not fetch customers from Bring API. Are Api key details correct.', null, $e);
        }
    }

    public function bookShipment(
        BookingRequest $req
    ) {
        $data = $req->toArray();

        $options = [
            'json' => $data,
        ];

        try {
            $request = $this->request('post', $this->_apiBringBooking, $options);
            return json_decode($request->getBody(), true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $resp = $e->getResponse();
            $json = json_decode($resp->getBody(), true);
            $errors = [];

            if (isset($json['consignments'])) {
                foreach ($json['consignments'] as $consignment) {
                    foreach ($consignment['errors'] as $error) {
                        $errors[] = $error;
                    }
                }
            }
            $ex = new BookingClientException('Got error from Bring API.', null, $e);
            $ex->setErrors($errors);

            throw $ex;
        }
    }

    public function setApiBringCustomers($apiBringCustomers)
    {
        $this->_apiBringCustomers = $apiBringCustomers;

        return $this;
    }

    public function setApiBringBooking($apiBringBooking)
    {
        $this->_apiBringBooking = $apiBringBooking;

        return $this;
    }
}
