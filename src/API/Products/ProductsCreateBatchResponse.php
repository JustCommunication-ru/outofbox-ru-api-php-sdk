<?php

namespace Outofbox\OutofboxSDK\API\Products;

use Outofbox\OutofboxSDK\API\AbstractResponse;

class ProductsCreateBatchResponse extends AbstractResponse
{
    protected array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function productIdForKey(string $key): int
    {
        if (!isset($this->items[$key])) {
            throw new \InvalidArgumentException('Item for key `' . $key . '` not found');
        }

        return $this->items[$key]['id'];
    }
}
