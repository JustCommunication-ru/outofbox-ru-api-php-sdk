<?php
namespace Outofbox\OutofboxSDK\API;

use Outofbox\OutofboxSDK\Model\Product;

class ProductsListResponse extends AbstractResponse
{
    /**
     * @var Product[]
     */
    protected $products;

    /**
     * @var int
     */
    protected $products_cnt;

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
        $this->products_cnt = sizeof($products);
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
    public function getProductsCnt()
    {
        return $this->products_cnt;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->count;
    }

    public function isEmpty()
    {
        return $this->products_cnt === 0;
    }
}