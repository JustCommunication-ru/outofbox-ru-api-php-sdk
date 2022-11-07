<?php

namespace Outofbox\OutofboxSDK\Model;

class ShopOrder
{
    /**
     * @var string
     */
    public $number;

    /**
     * @var ShopOrderItem[]
     */
    public $items = [];

    /**
     * @var DictionaryValue|null
     */
    public $status;

    /**
     * @var DictionaryValue|null
     */
    public $deliveryMethod;

    /**
     * @var DictionaryValue|null
     */
    public $paymentMethod;

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return DictionaryValue|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return DictionaryValue|null
     */
    public function getDeliveryMethod()
    {
        return $this->deliveryMethod;
    }

    /**
     * @return DictionaryValue|null
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @return ShopOrderItem[]
     */
    public function getItems()
    {
        return $this->items;
    }
}
