<?php

namespace Outofbox\OutofboxSDK\API\Warehouse\Warehouse3;

class IncomeStatusDTO
{
    public const STATE_SUCCESS = 'success';
    public const STATE_ERROR = 'error';

    protected string $state;
    public ?IncomeStatusItemDTO $item = null;

    /**
     * @param ?IncomeStatusItemDTO $item
     */
    public function __construct(string $state, ?IncomeStatusItemDTO $item = null)
    {
        $this->state = $state;
        $this->item = $item;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function isSuccess(): bool
    {
        return $this->state === self::STATE_SUCCESS;
    }

    public function isError(): bool
    {
        return $this->state === self::STATE_ERROR;
    }

    public function getItem(): ?IncomeStatusItemDTO
    {
        return $this->item;
    }
}
