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
     * @var int
     */
    protected $store_id;

    /**
     * @var ProductShopOrderItem[]
     */
    protected $products = [];

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

    public function createHttpClientParams()
    {
        $form_params = [];
        if ($this->phone_number) {
            $form_params['phone_number'] = $this->phone_number;
        }

        if ($this->store_id) {
            $form_params['store'] = $this->store_id;
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