<?php

namespace Outofbox\OutofboxSDK\Model;

class ShopOrderItem
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var int|float
     */
    public $price;

    /**
     * @var int|float
     */
    public $amount;

    /**
     * @var int
     */
    public $quantity;

    /**
     * @var float|null
     */
    public $item_weight;
}
