<?php

namespace Outofbox\OutofboxSDK\API\Shipments;

use Outofbox\OutofboxSDK\API\AbstractRequest;

class ShipmentByBarcodeRequest extends AbstractRequest
{
    const HTTP_METHOD = 'GET';
    const RESPONSE_CLASS = ShipmentRegisterResponse::class;

    /**
     * @var string
     */
    protected $barcode;

    /**
     * @param string $barcode
     */
    public function __construct(string $barcode)
    {
        $this->barcode = $barcode;
    }

    public function getUri()
    {
        return '_api/private/shipments/barcode-' . $this->barcode;
    }
}
