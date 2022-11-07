<?php

namespace Outofbox\OutofboxSDK\Serializer;

use Outofbox\OutofboxSDK\Model\Image;
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

        $images = $product->getImages();
        $images_objects = [];
        foreach ($images as $image_data) {
            if ($image_data instanceof Image) {
                $images_objects[] = $image_data;
            } elseif (is_array($image_data) && isset($image_data['path'])) {
                $image = new Image();
                $image->path = $image_data['path'];
                if (isset($image_data['modifications'])) {
                    $image->modifications = $image_data['modifications'];
                }

                $images_objects[] = $image;
            }
        }

        $product
            ->setCreatedAt(new \DateTime($data['created_at']))
            ->setImages($images_objects)
        ;

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
