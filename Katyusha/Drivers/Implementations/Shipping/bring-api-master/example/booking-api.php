<?php

require '../vendor/autoload.php';

use Trafficfox\Bring\API\Client\BookingClient;
use Trafficfox\Bring\API\Contract\Booking;
use Trafficfox\Bring\API\Data\BringData;

// These 3 variable credentials is provided via the My Bring login interface.
$bringUid = getenv('BRING_UID');
$bringApiKey = getenv('BRING_API_KEY');
$bringCustomerNumber = getenv('BRING_CUSTOMER');

$bringTestMode = true; // Setting this to false will send orders to Bring! Careful. This is for testing purposes.

$weight = 1; // 1 kg.
$length = 31;
$width = 21;
$height = 6;

$bringProductId = BringData::PRODUCT_SERVICEPAKKE;

// See http://developer.bring.com/api/booking/ ( Authentication section ) . You will need Client id, api key and client url.
$credentials = new \Trafficfox\Bring\API\Client\Credentials('http://mydomain.no', $bringUid, $bringApiKey);

// Create a booking client.
$client = new BookingClient($credentials);

// Send package in 5 hours..
$shipDate = new DateTime('now');
$shipDate->modify('+5 hours');

// What bring product we want to use for shipping the package(s).

$bringProduct = new Booking\BookingRequest\Consignment\Product();
$bringProduct->setId($bringProductId);
$bringProduct->setCustomerNumber($bringCustomerNumber);

// Create a new package.

$consignmentPackage = new Booking\BookingRequest\Consignment\Package();
$consignmentPackage->setWeightInKg($weight);
$consignmentPackage->setDimensionHeightInCm($height);
$consignmentPackage->setDimensionLengthInCm($length);
$consignmentPackage->setDimensionWidthInCm($width);

// Create a consignment

$consignment = new Booking\BookingRequest\Consignment();
$consignment->addPackage($consignmentPackage);
$consignment->setProduct($bringProduct);
$consignment->setShippingDateTime($shipDate);

// Recipient

$recipient = new Booking\BookingRequest\Consignment\Address();
$recipient->setAddressLine('Veien 32');
$recipient->setCity('Bergen');
$recipient->setCountryCode('NO');
$recipient->setName('Privat person');
$recipient->setPostalCode(5097);
$recipient->setReference('Customer-id-in-DB');
$consignment->setRecipient($recipient);

// Sender

$sender = new Booking\BookingRequest\Consignment\Address();
$sender->setAddressLine('Veien 32');
$sender->setCity('Bergen');
$sender->setCountryCode('NO');
$sender->setName('Min bedrift');
$sender->setPostalCode(5097);
$contact = new Booking\BookingRequest\Consignment\Contact();
$contact->setEmail('mycompany@test.com');
$contact->setPhoneNumber('40000000');
$sender->setContact($contact);
$consignment->setSender($sender);

$request = new Booking\BookingRequest();
$request->addConsignment($consignment);
$request->setTestIndicator($bringTestMode);

try {
    echo "Using Bring UID: ${bringUid}, Key: ${bringApiKey}, Customer number: ${bringCustomerNumber}\n";

    $result = $client->bookShipment($request);
    print_r($result);

    // Catch response errors.
} catch (\Trafficfox\Bring\API\Client\BookingClientException $e) {
    print_r($e->getErrors());

    throw $e;
    // Catch errors that relates to the contract / request.
} catch (\Trafficfox\Bring\API\Contract\ContractValidationException $e) {
    throw $e;
}
