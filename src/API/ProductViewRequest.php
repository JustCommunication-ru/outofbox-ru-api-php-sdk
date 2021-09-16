<?php
namespace Outofbox\OutofboxSDK\API;

use Outofbox\OutofboxSDK\Model\Product;

class ProductViewRequest extends AbstractRequest
{
    const RESPONSE_CLASS = ProductViewResponse::class;

    /**
     * @var int
     */
    protected $product_id;

    /**
     * Image sizes
     *
     * @var array
     */
    protected $images_sizes = [
        'small' => [
            'fs' => 'ofb-small',
            'filecpd' => [
                'type' => 'custom',
                'width' => 80,
                'height' => 80,
                'crop' => true
            ]
        ]
    ];

    /**
     * ProductViewRequest constructor.
     * @param int $product_id
     */
    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    public static function withProductID($product_id)
    {
        return new ProductViewRequest($product_id);
    }

    public static function withProduct(Product $product)
    {
        return self::withProductID($product->getId());
    }

    /**
     * @return array
     */
    public function getImagesSizes()
    {
        return $this->images_sizes;
    }

    /**
     * @param array $images_sizes
     * @return $this
     */
    public function setImagesSizes(array $images_sizes)
    {
        $this->images_sizes = $images_sizes;
        return $this;
    }

    /**
     * @param string $size_key
     * @param array $size_params
     * @return $this
     */
    public function addImageSize($size_key, array $size_params)
    {
        $this->images_sizes[$size_key] = $size_params;
        return $this;
    }

    public function getUri()
    {
        return '/_api/private/products/' . $this->product_id;
    }

    public function createHttpClientParams()
    {
        $query_params = [
            'api_version' => 'v2'
        ];

        if ($this->images_sizes) {
            $query_params['images_modifications'] = $this->images_sizes;
        }

        return [
            'query' => $query_params
        ];
    }
}