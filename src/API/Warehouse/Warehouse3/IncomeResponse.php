<?php

namespace Outofbox\OutofboxSDK\API\Warehouse\Warehouse3;

use Outofbox\OutofboxSDK\API\AbstractResponse;

class IncomeResponse extends AbstractResponse
{
    /**
     * @var IncomeStatusDTO[]
     */
    protected array $items;

    /**
     * @param IncomeStatusDTO[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getItem(string $key): IncomeStatusDTO
    {
        if (!isset($this->items[$key])) {
            throw new \InvalidArgumentException('Item for key `' . $key . '` not found');
        }

        return $this->items[$key];
    }
}
