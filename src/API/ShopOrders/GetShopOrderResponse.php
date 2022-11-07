<?php

namespace Outofbox\OutofboxSDK\API\ShopOrders;

use Outofbox\OutofboxSDK\Model\ShopOrder;

class GetShopOrderResponse
{
    /**
     * @var ShopOrder
     */
    protected $shop_order;

    /**
     * GetShopOrderResponse constructor.
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
