<?php
namespace Outofbox\OutofboxSDK\Serializer;

use Outofbox\OutofboxSDK\Model\Product;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ProductDenormalizer extends ObjectNormalizer
{
    /**
     * @inheritDoc
     */
    public function denormalize($data, $type, $format = null, array $context = [])
    {
        /** @var Product $product */
        $product = parent::denormalize($data, $type, $format, $context);

        foreach ($data['fields_names'] as $field_title => $field_name) {
            $product->{$field_name} = $data[$field_name];
        }

        $product->setCreatedAt(new \DateTime($data['created_at']));

        return $product;
    }

    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === Product::class;
    }
}