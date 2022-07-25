<?php

namespace Outofbox\OutofboxSDK\API\Products;

use Outofbox\OutofboxSDK\API\AbstractResponse;
use Outofbox\OutofboxSDK\Model\Product;

class ProductUpdateResponse extends AbstractResponse
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * ProductViewResponse constructor.
     * @param Product $product
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
