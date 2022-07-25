<?php

namespace Outofbox\OutofboxSDK\API\Warehouse;

use Outofbox\OutofboxSDK\API\AbstractResponse;
use Outofbox\OutofboxSDK\Model\WarehouseStore;

class StoresListResponse extends AbstractResponse
{
    /**
     * @var WarehouseStore[]
     */
    protected $stores;

    /**
     * StoresListResponse constructor.
     * @param WarehouseStore[] $stores
     */
    public function __construct(array $stores)
    {
        $this->stores = $stores;
    }

    /**
     * @return WarehouseStore[]
     */
    public function getStores()
    {
        return $this->stores;
    }
}
