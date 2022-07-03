<?php

namespace App\Http\Controllers;

use Features\Shops\Shop;

/**
 * @property Shop shop
 * @property string id
 * @property string namespace
 * @property string terms
 * @property string name
 * @property string logo
 * @property string banner
 * @property string description
 * @property bool is_open
 * @property string city
 * @property int price_range
 * @property string last_order_at
 * @property bool currently_open
 * @property string shop_type
 * @property string takeaway
 * @property string address
 * @property mixed zip
 * @property mixed open_hours
 * @property bool dark_design
 * @property string about_text
 * @property string main_color
 * @property string gradient_first_color
 * @property string gradient_second_color
 * @property string url
 * @property string style_css
 * @property int logo_height
 * @property string short_intro
 * @property bool hide_header
 * @property bool offline
 * @property array is
 * @property array features
 * @property string vipps_login_link
 * @property array payment_methods
 * @property int number_of_active_payment_methods
 * @property stdClass catalog
 * @property string banner_url
 * @property string logo_url
 * @property bool is_ecommerce
 */
class ShopSsrDataCompiler
{
    public function __construct(?Shop $shop = null)
    {
        $this->shop = $shop;
//        $this->terms                   = str_replace(["\n", '  '], ['', ' '], view('documents.bambora-checkout-terms', ['shop' => $this->shop])->render());
        $this->id = $shop->getId();
        $this->name = $shop->getNamespace();
        $this->namespace = $shop->getNamespace();
        $this->url = $shop->url;
        $this->name = $shop->getName();
        $this->city = $shop->city;
        $this->address = $shop->getAddress();
        $this->zip = $shop->getZip();
        $this->logo = $shop->logo_url;
        $this->banner = $shop->banner_url;
        $this->is_open = $shop->isOpen();
        $this->open_hours = $shop->todaysOpeningHours()?->parseDaysOpeningHoursForHuman();
        $this->description = $shop->getShortIntro();
        $this->shop_type = 'food';
        $this->banner_url = $shop->banner_url;
        $this->logo_url = $shop->logo_url;
        $this->url = $shop->url;
        $this->catalog = $shop->getCatalog();

        $this->setFeatures()->setIsValues()->setTakeawaySettings()->setPaymentMethods();

        $numActive = 0;
        foreach ($this->payment_methods as $method => $active) {
            if ($active) {
                $numActive++;
            }
        }

        $this->number_of_active_payment_methods = $numActive;

        unset($this->shop);
    }

    public static function getAnInstance(Shop $shop)
    {
        return new self($shop);
    }

    private function setPaymentMethods(): self
    {
        $this->payment_methods = [
            'vipps' => $this->shop->apiKeyStore->isVippsActive(),
            'bambora' => $this->shop->apiKeyStore->isBamboraActive(),
            'stripe' => $this->shop->apiKeyStore->isStripeActive(),
            'klarna' => $this->shop->apiKeyStore->isKlarnaActive(),
        ];

        return $this;
    }

    private function setIsValues(): self
    {
        $this->is = [
            'restaurant' => $this->shop->isRestaurant(),
            'online_store' => $this->shop->isEcommerce(),
        ];

        return $this;
    }

    private function setTakeawaySettings(): self
    {
        $info = $this->shop->takeawayMinMaxTimes();

        $this->takeaway = [
            'min_possible_time' => $info['min'],
            'max_possible_time' => $info['max'],
        ];

        return $this;
    }

    private function setFeatures(): self
    {
        $this->features = [
            'loyalty_program' => true,
            'tips' => $this->shop->restaurantSettings?->areTipsEnabled(),
            'coupons' => false,
            'restaurant' => [
                'delivery' => false,
                'take_away' => $this->shop->restaurantSettings?->isTakeAwayEnabled(),
                'eating_in' => $this->shop->restaurantSettings?->areTablesEnabled(),
            ],
        ];

        return $this;
    }
}
