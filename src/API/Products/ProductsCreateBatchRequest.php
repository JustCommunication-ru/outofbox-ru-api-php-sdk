<?php

namespace Outofbox\OutofboxSDK\API\Products;

use Outofbox\OutofboxSDK\API\AbstractRequest;

class ProductsCreateBatchRequest extends AbstractRequest
{
    const URI = '_api/private/products/actions/batch-create';
    const HTTP_METHOD = 'POST';
    const RESPONSE_CLASS = ProductsCreateBatchResponse::class;

    /**
     * @var CreateProductDTO[]
     */
    protected array $items;

    /**
     * @param CreateProductDTO[]  $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return CreateProductDTO[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param CreateProductDTO[] $items
     */
    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    public function addItem(string $key, CreateProductDTO $item): self
    {
        $this->items[$key] = $item;
        return $this;
    }

    public function createHttpClientParams()
    {
        $form_params = [
            'items' => []
        ];

        foreach ($this->items as $item_key => $item) {
            $item_struct = [
                'type_id' => $item->type_id,
                'title' => $item->title,
                'description' => $item->description
            ];

            foreach ($item->fields as $field_name => $field_value) {
                $item_struct[$field_name] = $field_value;
            }

            $form_params['items'][$item_key] = $item_struct;
        }

        return [
            'form_params' => $form_params
        ];
    }
}
