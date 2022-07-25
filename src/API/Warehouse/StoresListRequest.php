<?php

namespace Outofbox\OutofboxSDK\API\Warehouse;

use Outofbox\OutofboxSDK\API\AbstractRequest;

class StoresListRequest extends AbstractRequest
{
    const URI = '/_api/private/warehouse-stores';
    const RESPONSE_CLASS = StoresListResponse::class;
}
