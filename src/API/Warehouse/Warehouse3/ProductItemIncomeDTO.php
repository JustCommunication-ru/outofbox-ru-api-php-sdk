<?php

namespace Outofbox\OutofboxSDK\API\Warehouse\Warehouse3;

class ProductItemIncomeDTO
{
    public string $barcode;
    public ?ProductItemIncomeChangeDTO $change = null;
}
