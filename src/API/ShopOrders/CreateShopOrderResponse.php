<?php

namespace Outofbox\OutofboxSDK\API\ShopOrders;

use Outofbox\OutofboxSDK\API\AbstractResponse;
use Outofbox\OutofboxSDK\Model\ShopOrder;

class CreateShopOrderResponse extends AbstractResponse
{
    /**
     * @var ShopOrder
     */
    protected $shop_order;

    /**
     * CreateShopOrderResponse constructor.
     * @param ShopOrder $shop_order
     */
    public function __construct(ShopOrder $shop_order)
    {
        $this->shop_order = $shop_order;
    }

    /**
     * @return ShopOrder
     */
    public function getShopOrder()
    {
        return $this->shop_order;
    }
}
