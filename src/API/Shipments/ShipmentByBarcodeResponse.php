<?php

namespace Outofbox\OutofboxSDK\API\Shipments;

use Outofbox\OutofboxSDK\API\AbstractResponse;
use Outofbox\OutofboxSDK\Model\Shipment;

class ShipmentByBarcodeResponse extends AbstractResponse
{
    /**
     * @var Shipment
     */
    protected $shipment;

    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * @return Shipment
     */
    public function getShipment()
    {
        return $this->shipment;
    }
}
