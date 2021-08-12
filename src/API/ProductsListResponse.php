<?php
namespace Outofbox\OutofboxSDK\API;

use Outofbox\OutofboxSDK\Model\Product;

class ProductsListResponse
{
    /**
     * @var Product[]
     */
    protected $products;

    /**
     * @var integer
     */
    protected $count;

    /**
     * ProductsListResponse constructor.
     * @param Product[] $products
     * @param integer $count
     */
    public function __construct($products, $count)
    {
        $this->products = $products;
        $this->count = $count;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }
}