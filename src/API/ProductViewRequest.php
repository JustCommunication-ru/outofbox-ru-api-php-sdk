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

    public function getUri()
    {
        return '/_api/private/products/' . $this->product_id;
    }

    public function createHttpClientParams()
    {
        return [
            'query' => [
                'api_version' => 'v2'
            ]
        ];
    }
}