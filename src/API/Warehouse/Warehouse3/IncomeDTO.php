<?php

namespace Outofbox\OutofboxSDK\API\Warehouse\Warehouse3;

class IncomeDTO
{
    public int $product_id;
    public int $action_id;
    public ProductItemIncomeDTO $item;
    public ?IncomeChangeDTO $change = null;
}
