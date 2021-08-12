<?php
namespace Outofbox\OutofboxSDK\API;

use Outofbox\OutofboxSDK\Model\Product;

class ProductViewResponse
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