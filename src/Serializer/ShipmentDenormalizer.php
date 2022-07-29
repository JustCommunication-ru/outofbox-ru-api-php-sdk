<?php

namespace Outofbox\OutofboxSDK\Serializer;

use Outofbox\OutofboxSDK\Model\Shipment;
use Outofbox\OutofboxSDK\Model\ShipmentState;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ShipmentDenormalizer extends ObjectNormalizer
{
    /**
     * @inheritDoc
     */
    public function denormalize($data, $type, $format = null, array $context = [])
    {
        /** @var Shipment $shipment */
        $shipment = parent::denormalize($data, $type, $format, $context);

        if (isset($data['current_state'])) {
            $state = new ShipmentState();
            $state->type = $data['current_state']['type'];
            $state->value = $data['current_state']['value'];
            $state->title = $data['current_state']['title'];
            $shipment->currentState = $state;
        }

        if (isset($data['state_updated_at'])) {
            $shipment->setStateUpdatedAt(new \DateTime($data['state_updated_at']));
        }

        return $shipment;
    }

    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === Shipment::class;
    }
}
