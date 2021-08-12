<?php
namespace Outofbox\OutofboxSDK\Model;

class Product
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var float|integer
     */
    protected $price;

    /**
     * @var integer
     */
    protected $quantity;

    /**
     * @var integer
     */
    protected $reserved_quantity;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var array
     */
    protected $fields_names;

    /**
     * @var string
     */
    protected $barcodes;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float|int $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getReservedQuantity()
    {
        return $this->reserved_quantity;
    }

    /**
     * @param int $reserved_quantity
     * @return Product
     */
    public function setReservedQuantity($reserved_quantity)
    {
        $this->reserved_quantity = $reserved_quantity;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return array
     */
    public function getFieldsNames()
    {
        return $this->fields_names;
    }

    /**
     * @param array $fields_names
     * @return Product
     */
    public function setFieldsNames($fields_names)
    {
        $this->fields_names = $fields_names;
        return $this;
    }

    /**
     * @return string
     */
    public function getBarcodes()
    {
        return $this->barcodes;
    }

    /**
     * @param string $barcodes
     * @return Product
     */
    public function setBarcodes($barcodes)
    {
        $this->barcodes = $barcodes;
        return $this;
    }

    /**
     * @param string $field_label
     * @return mixed|null
     */
    public function getFieldValue($field_label)
    {
        if (!isset($this->fields_names[$field_label])) {
            return null;
        }

        return $this->{$this->fields_names[$field_label]};
    }
}