<?php
namespace Outofbox\OutofboxSDK\API\Products;

use Outofbox\OutofboxSDK\API\AbstractRequest;
use Outofbox\OutofboxSDK\Model\Product;

class ProductUpdateRequest extends AbstractRequest
{
    const RESPONSE_CLASS = ProductUpdateResponse::class;
    const HTTP_METHOD = 'PATCH';

    /**
     * @var int
     */
    protected $product_id;

    protected $params = [];

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
        return new self($product_id);
    }

    public static function withProduct(Product $product)
    {
        return self::withProductID($product->getId());
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return ProductUpdateRequest
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function addParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function clearParam($name)
    {
        if (array_key_exists($name, $this->params)) {
            unset($this->params[$name]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUri()
    {
        return '_api/private/products/' . $this->product_id;
    }

    public function createHttpClientParams()
    {
        $query_params = [];

        $form_params = $this->params;

        return [
            'query' => $query_params,
            'form_params' => $form_params
        ];
    }
}