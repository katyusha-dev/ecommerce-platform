<?php

namespace Trafficfox\Bring\API\Contract\ShippingGuide;

use DateTime;
use Trafficfox\Bring\API\Contract\ApiEntity;

class PriceRequest extends ApiEntity
{
    protected $_data = [
        'from' => null,
        'to' => null,
        'weightInGrams' => null,
        'width' => null,
        'length' => null,
        'height' => null,
        'date' => null,
        'time' => null,
        'edi' => null,
        'postingAtPostOffice' => null,
        'additional' => null,
        'priceAdjustments' => null,
        'pid' => null,
        'product' => null,
        'language' => null,
        'volumeSpecial' => null,
        'fromCountry' => null,
        'toCountry' => null,
        'customernumber' => null,
    ];

    /**
     * From postal code.
     *
     * @param string $from Example: 7600
     *
     * @return $this
     */
    public function setFrom(string $from)
    {
        return $this->setData('frompostalcode', $from);
    }

    /**
     * To postal code.
     *
     * @param string $to Example: 7600
     *
     * @return $this
     */
    public function setTo(string $to)
    {
        return $this->setData('topostalcode', $to);
    }

    /**
     * Weight of package in grams.
     *
     * @param $weightInGrams Example: 1500
     *
     * @return $this
     */
    public function setWeightInGrams($weightInGrams)
    {
        return $this->setData('weight', $weightInGrams);
    }

    /**
     * Package width in centimeters.
     *
     * @param $width
     *
     * @return $this
     */
    public function setWidth($width)
    {
        return $this->setData('width', $width);
    }

    /**
     * Package length in centimeters.
     *
     * @param $length
     *
     * @return $this
     */
    public function setLength($length)
    {
        return $this->setData('length', $length);
    }

    /**
     * Package height in centimeters.
     *
     * @param $height
     *
     * @return $this
     */
    public function setHeight($height)
    {
        return $this->setData('height', $height);
    }

    /**
     * customernumber from system configurations.
     *
     * @param $customerNumber
     *
     * @return $this
     */
    public function setCustomerNumber($customerNumber)
    {
        return $this->setData('customernumber', $customerNumber);
    }

    /**
     * Shipping date. Specifies which date the parcel will be delivered to Bring (within the time limit), and is used to calculate the delivery date.
     *
     * @return $this
     */
    public function setDate(DateTime $dateTime)
    {
        return $this->setData('date', $dateTime->format('Y-m-d'));
    }

    /**
     * Shipping time may be specified. Note that Bring’s courier products are the only one affected by this parameter. Time is specified in ISO format, HH:mm.
     *
     * @return $this
     */
    public function setTime(DateTime $dateTime)
    {
        return $this->setData('time', $dateTime->format('H:i'));
    }

    /**
     * @param $edi
     *
     * @return $this
     */
    public function setEdi($edi)
    {
        if ($edi) {
            return $this->setData('edi', (bool) $edi);
        }

        return $this->removeData('edi');
    }

    /**
     * @param $postingAtPostOffice
     *
     * @return $this
     */
    public function setPostingAtPostOffice($postingAtPostOffice)
    {
        return $this->setData('postingAtPostOffice', (bool) $postingAtPostOffice);
    }

    /**
     * @param $additional
     *
     * @return $this
     */
    public function addAdditional($additional)
    {
        return $this->addData('additionalservice', $additional);
    }

    /**
     * @param $priceAdjustments
     *
     * @return $this
     */
    public function setPriceAdjustments($priceAdjustments)
    {
        return $this->setData('priceAdjustments', $priceAdjustments);
    }

    /**
     * @param $pid
     *
     * @return $this
     */
    public function setPid($pid)
    {
        return $this->setData('pid', $pid);
    }

    /**
     * @param $product
     *
     * @return $this
     */
    public function addProduct($product)
    {
        return $this->addData('product', $product);
    }

    /**
     * @param $language
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        return $this->setData('language', $language);
    }

    /**
     * @param $volumeSpecial
     *
     * @return $this
     */
    public function setVolumeSpecial($volumeSpecial)
    {
        return $this->setData('volumeSpecial', (bool) $volumeSpecial);
    }

    /**
     * @param $fromCountry
     *
     * @return $this
     */
    public function setFromCountry($fromCountry)
    {
        return $this->setData('fromcountry', $fromCountry);
    }

    /**
     * @param $toCountry
     *
     * @return $this
     */
    public function setToCountry($toCountry)
    {
        return $this->setData('tocountry', $toCountry);
    }

    public function validate(): void
    {
    }
}
