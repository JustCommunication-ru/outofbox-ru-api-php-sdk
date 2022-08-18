<?php

namespace Outofbox\OutofboxSDK\API\ShopOrders;

use Outofbox\OutofboxSDK\API\AbstractRequest;
use Outofbox\OutofboxSDK\Model\ProductShopOrderItem;

class CreateShopOrderRequest extends AbstractRequest
{
    const URI = '_api/private/shop-orders';
    const HTTP_METHOD = 'POST';
    const RESPONSE_CLASS = CreateShopOrderResponse::class;

    /**
     * @var string
     */
    protected $phone_number;

    /**
     * @var int|null
     */
    protected $store_id;

    /**
     * @var ProductShopOrderItem[]
     */
    protected $products = [];

    /**
     * @var int|null
     */
    protected $city_id;

    /**
     * @var int|null
     */
    protected $delivery_method_id;

    /**
     * @var int|null
     */
    protected $source_id;

    /**
     * @var string|null
     */
    protected $comment;

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     * @return CreateShopOrderRequest
     */
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
        return $this;
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->store_id;
    }

    /**
     * @param int $store_id
     * @return CreateShopOrderRequest
     */
    public function setStoreId($store_id)
    {
        $this->store_id = $store_id;
        return $this;
    }

    /**
     * @param array $products
     * @return $this
     */
    public function setProducts(array $products)
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @return ProductShopOrderItem[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param ProductShopOrderItem $item
     * @return $this
     */
    public function addProduct(ProductShopOrderItem $item)
    {
        $this->products[] = $item;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCityId()
    {
        return $this->city_id;
    }

    /**
     * @param int|null $city_id
     * @return CreateShopOrderRequest
     */
    public function setCityId($city_id)
    {
        $this->city_id = $city_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDeliveryMethodId()
    {
        return $this->delivery_method_id;
    }

    /**
     * @param int|null $delivery_method_id
     * @return CreateShopOrderRequest
     */
    public function setDeliveryMethodId($delivery_method_id)
    {
        $this->delivery_method_id = $delivery_method_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getSourceId()
    {
        return $this->source_id;
    }

    /**
     * @param int $source_id
     * @return $this
     */
    public function setSourceId($source_id)
    {
        $this->source_id = $source_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return CreateShopOrderRequest
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    public function createHttpClientParams()
    {
        $form_params = [];
        if ($this->phone_number) {
            $form_params['phone_number'] = $this->phone_number;
        }

        if ($this->city_id) {
            $form_params['city_id'] = $this->city_id;
        }

        if ($this->delivery_method_id) {
            $form_params['delivery_method_id'] = $this->delivery_method_id;
        }

        if ($this->store_id) {
            $form_params['store'] = $this->store_id;
        }

        if ($this->source_id) {
            $form_params['source_id'] = $this->source_id;
        }

        if ($this->comment) {
            $form_params['comment'] = $this->comment;
        }

        $form_params['products'] = [];
        foreach ($this->products as $productShopOrderItem) {
            $form_params['products'][] = [
                'id' => $productShopOrderItem->getProductId(),
                'quantity' => $productShopOrderItem->getQuantity()
            ];
        }

        return [
            'form_params' => $form_params
        ];
    }
}
