<?php
namespace Outofbox\OutofboxSDK\API\Shipments;

use Outofbox\OutofboxSDK\API\AbstractRequest;
use Outofbox\OutofboxSDK\Model\Shipment;

class ShipmentRegisterRequest extends AbstractRequest
{
    const URI = '_api/private/shipments';
    const HTTP_METHOD = 'POST';
    const RESPONSE_CLASS = ShipmentRegisterResponse::class;

    /**
     * @var Shipment
     */
    protected $shipment;

    /**
     * ShipmentRegisterRequest constructor.
     * @param Shipment $shipment
     */
    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    public function createHttpClientParams()
    {
        $form_params = [
            'title' => $this->shipment->getTitle(),
            'receiver_phone_number' => $this->shipment->getReceiverPhoneNumber(),
            'comment' => $this->shipment->getComment(),
            'delivery_from_address' => $this->shipment->getDeliveryFromAddress(),
            'delivery_address' => $this->shipment->getDeliveryAddress()
        ];

        return [
            'form_params' => $form_params
        ];
    }
}