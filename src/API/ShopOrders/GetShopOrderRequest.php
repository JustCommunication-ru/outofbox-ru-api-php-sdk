<?php

namespace Outofbox\OutofboxSDK\API\ShopOrders;

use Outofbox\OutofboxSDK\API\AbstractRequest;

class GetShopOrderRequest extends AbstractRequest
{
    const URI = '_api/private/shop-orders';
    const HTTP_METHOD = 'GET';
    const RESPONSE_CLASS = GetShopOrderResponse::class;

    /**
     * @var string
     */
    protected $order_number;

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->order_number;
    }

    /**
     * @param string $order_number
     * @return GetShopOrderRequest
     */
    public function setOrderNumber($order_number)
    {
        $this->order_number = $order_number;
        return $this;
    }

    public function getUri()
    {
        return $this::URI . '/' . $this->order_number . '/full';
    }
}
