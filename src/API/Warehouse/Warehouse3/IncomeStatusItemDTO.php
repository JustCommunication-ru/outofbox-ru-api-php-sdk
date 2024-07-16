<?php

namespace Outofbox\OutofboxSDK\API\Warehouse\Warehouse3;

class IncomeStatusItemDTO
{
    protected int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
