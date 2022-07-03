<?php

require '../vendor/autoload.php';

use Trafficfox\Bring\API\Contract\EasyReturn;

///
/// Create needed data.
///

$customerId = 1000;

$packageId = '70722150074149957';
$shipmentId = '70722150074149957';
$productCode = 0341; // always 0341
$weight = 5;

$senderCountryCode = 'NO';
$senderName = 'Ola Nordmann';
$senderCity = 'Bergen';
$senderStreet = 'Nagelgården 6';

$recipientName = 'Ola Nordmann';
$recipientCity = 'Bergen';
$recipientCountryCode = 'NO';
$recipientStreet = 'Nagelgården 6';

$shipDate = new DateTime('now');
$shipDate->modify('+5 hours');

///
/// Construct a validated request.
///

// These 3 variable credentials is provided via the My Bring login interface.
$bringUid = getenv('BRING_UID');
$bringApiKey = getenv('BRING_API_KEY');
$bringCustomerNumber = getenv('BRING_CUSTOMER');

// See http://developer.bring.com/api/booking/ ( Authentication section ) . You will need Client id, api key and client url.
$credentials = new \Trafficfox\Bring\API\Client\Credentials('http://mydomain.no', $bringUid, $bringApiKey);
$client = new \Trafficfox\Bring\API\Client\EasyReturnClient($credentials);

$request = new EasyReturn\LabelRequest();

$request->setOrderDate($shipDate);
$request->setCustomerId($bringCustomerNumber);

$recipient = new EasyReturn\LabelRequest\Recipient();
$recipient->setName($recipientName);
$recipient->setCity($recipientCity);
$recipient->setCountryCode($recipientCountryCode);
$recipient->setStreet($recipientStreet);

$request->setRecipient($recipient);

$sender = new EasyReturn\LabelRequest\Sender();
$sender->setName($senderName);
$sender->setCity($senderCity);
$sender->setCountryCode($senderCountryCode);
$sender->setStreet($senderStreet);

$request->setSender($sender);

$shipment = new EasyReturn\LabelRequest\Shipment();
$shipment->setPackageId($packageId);
$shipment->setShipmentId($shipmentId);
$shipment->setProductCode($productCode);
$shipment->setWeight($weight);

$request->setShipment($shipment);

try {
    $result = $client->create($request);
    print_r($result);

    // Catch response errors.
} catch (\Trafficfox\Bring\API\Client\EasyReturnClientException $e) {
    print_r($e->getErrors());

    throw $e;
    // Catch errors that relates to the contract / request.
} catch (\Trafficfox\Bring\API\Contract\ContractValidationException $e) {
    throw $e;
}
