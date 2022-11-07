<?php

namespace Outofbox\OutofboxSDK\Serializer;

use Outofbox\OutofboxSDK\Model\DictionaryValue;
use Outofbox\OutofboxSDK\Model\ShopOrder;
use Outofbox\OutofboxSDK\Model\ShopOrderItem;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ShopOrderDenormalizer extends ObjectNormalizer implements DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    /**
     * @inheritDoc
     */
    public function denormalize($data, $type, $format = null, array $context = [])
    {
        /** @var ShopOrder $shopOrder */
        $shopOrder = parent::denormalize($data, $type, $format, $context);

        if (isset($data['delivery_method'])) {
            $dictionaryValue = new DictionaryValue();
            $dictionaryValue->id = $data['delivery_method']['id'];
            $dictionaryValue->value = $data['delivery_method']['value'];
            $shopOrder->deliveryMethod = $dictionaryValue;
        }

        if (isset($data['payment_method'])) {
            $dictionaryValue = new DictionaryValue();
            $dictionaryValue->id = $data['payment_method']['id'];
            $dictionaryValue->value = $data['payment_method']['value'];
            $shopOrder->paymentMethod = $dictionaryValue;
        }

        $items = [];
        foreach ($shopOrder->items as $shopOrderItem) {
            if ($shopOrderItem instanceof ShopOrderItem) {
                $items[] = $shopOrderItem;
            } elseif (is_array($shopOrderItem)) {
                $items[] = $this->denormalizer->denormalize($shopOrderItem, ShopOrderItem::class);
            } else {
                $items[] = null;
            }
        }

        $shopOrder->items = $items;

        return $shopOrder;
    }

    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === ShopOrder::class;
    }
}
