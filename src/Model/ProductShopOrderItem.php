<?php
namespace Outofbox\OutofboxSDK\Model;

class ProductShopOrderItem
{
    /**
     * @var int
     */
    protected $product_id;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @param int $product_id
     * @param int $quantity
     * @return self
     */
    public static function create($product_id, $quantity)
    {
        $self = new self();
        $self
            ->setProductId($product_id)
            ->setQuantity($quantity)
        ;

        return $self;
    }

    /**
     * @param int $product_id
     * @return $this
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param int $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}