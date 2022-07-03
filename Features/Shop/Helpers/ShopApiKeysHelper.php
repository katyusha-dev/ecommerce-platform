<?php

namespace Features\Shop\Helpers;

use App\Exceptions\PaymentProviderException;
use Features\Purchasing\Enums\PaymentProvidersEnum;
use Features\Shop\Shop;
use Katyusha\Drivers\Payment\Consignments\BamboraApiConsignment;
use Katyusha\Drivers\Payment\Consignments\StripeApiConsignment;
use Katyusha\Drivers\Payment\Consignments\VippsApiConsignment;

abstract class ShopApiKeysHelper
{
    /**
     * @throws PaymentProviderException
     */
    public static function getPaymentProviderConsignment(Shop $shop, PaymentProvidersEnum $provider): BamboraApiConsignment | VippsApiConsignment |StripeApiConsignment
    {
        $apiKeys = $shop->apiKeys;

        switch ($provider) {
            case PaymentProvidersEnum::STRIPE:
                return new StripeApiConsignment(! $apiKeys->stripe_production_mode, $apiKeys->stripe_production_mode ? $apiKeys->stripe_prod_pub_key : $apiKeys->stripe_test_pub_key, $apiKeys->stripe_production_mode ? $apiKeys->stripe_prod_secret_key : $apiKeys->stripe_test_secret_key);
            case PaymentProvidersEnum::VIPPS:
                return new VippsApiConsignment($apiKeys->vipps_client_id, $apiKeys->vipps_client_secret, $apiKeys->vipps_merchant_serial_number, $apiKeys->vipps_ecom_token_sub_key, ! $apiKeys->vipps_production_mode);
        }

        throw new PaymentProviderException("No provider found with name ${provider}");
    }
}
