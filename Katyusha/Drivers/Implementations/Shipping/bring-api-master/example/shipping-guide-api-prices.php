<?php

require '../vendor/autoload.php';

use Trafficfox\Bring\API\Contract\ShippingGuide;
use Trafficfox\Bring\API\Data\BringData;
use Trafficfox\Bring\API\Data\ShippingGuideData;

// See http://developer.bring.com/api/booking/ ( Authentication section ) . You will need Client id, api key and client url.
$client = new \Trafficfox\Bring\API\Client\ShippingGuideClient(new \Trafficfox\Bring\API\Client\Credentials('http://mydomain.no'));

$request = new ShippingGuide\PriceRequest();

$request->setFromCountry('NO');
$request->setFrom('5097');

$request->setToCountry('NO');
$request->setTo('5155');

$request->setWeightInGrams(1500);

$request->addAdditional(ShippingGuideData::EVARSLING); // Makes it cheaper, and environment friendly! :)

// Set possible shipping products
$request->addProduct(BringData::PRODUCT_SERVICEPAKKE)
    ->addProduct(BringData::PRODUCT_MINIPAKKE)
    ->addProduct(BringData::PRODUCT_PA_DOREN);

// If we use EDI..
$request->setEdi(true);

try {
    $prices = $client->getPrices($request);

    print_r($prices);
} catch (\Trafficfox\Bring\API\Client\ShippingGuideClientException $e) {
    throw $e; // just re-throw for testing.
} catch (\Trafficfox\Bring\API\Contract\ContractValidationException $e) {
    throw $e;
}
