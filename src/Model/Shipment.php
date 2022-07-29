<?php

namespace Outofbox\OutofboxSDK\Model;

class Shipment
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $receiver_phone_number;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var string
     */
    protected $delivery_from_address;

    /**
     * @var string
     */
    protected $delivery_address;

    /**
     * @var string|null
     */
    protected $barcode;

    /**
     * @var ShipmentState|null
     */
    public $currentState;

    /**
     * @var \DateTime|null
     */
    protected $stateUpdatedAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Shipment
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
     * @return Shipment
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverPhoneNumber()
    {
        return $this->receiver_phone_number;
    }

    /**
     * @param string $receiver_phone_number
     * @return Shipment
     */
    public function setReceiverPhoneNumber($receiver_phone_number)
    {
        $this->receiver_phone_number = $receiver_phone_number;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return Shipment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeliveryFromAddress()
    {
        return $this->delivery_from_address;
    }

    /**
     * @param string $delivery_from_address
     * @return Shipment
     */
    public function setDeliveryFromAddress($delivery_from_address)
    {
        $this->delivery_from_address = $delivery_from_address;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeliveryAddress()
    {
        return $this->delivery_address;
    }

    /**
     * @param string $delivery_address
     * @return Shipment
     */
    public function setDeliveryAddress($delivery_address)
    {
        $this->delivery_address = $delivery_address;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * @param string|null $barcode
     * @return Shipment
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getStateUpdatedAt()
    {
        return $this->stateUpdatedAt;
    }

    /**
     * @param \DateTime|null $stateUpdatedAt
     * @return Shipment
     */
    public function setStateUpdatedAt($stateUpdatedAt)
    {
        $this->stateUpdatedAt = $stateUpdatedAt;
        return $this;
    }
}
