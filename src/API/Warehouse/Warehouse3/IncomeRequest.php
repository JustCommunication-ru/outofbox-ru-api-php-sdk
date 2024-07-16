<?php

namespace Outofbox\OutofboxSDK\API\Warehouse\Warehouse3;

use Outofbox\OutofboxSDK\API\AbstractRequest;

class IncomeRequest extends AbstractRequest
{
    const URI = '_api/private/warehouse/wh3/income';
    const HTTP_METHOD = 'POST';
    const RESPONSE_CLASS = IncomeResponse::class;

    protected int $procurement_id;

    /**
     * @var IncomeDTO[]
     */
    protected array $items;

    /**
     * @param IncomeDTO[] $items
     */
    public function __construct(int $procurement_id, array $items = [])
    {
        $this->procurement_id = $procurement_id;
        $this->items = $items;
    }

    /**
     * @return IncomeDTO[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param IncomeDTO[] $items
     */
    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    public function createHttpClientParams()
    {
        $form_params = [
            'procurement_id' => $this->procurement_id,
            'items' => []
        ];

        foreach ($this->items as $item_key => $item) {
            $item_struct = [
                'product' => $item->product_id,
                'action' => $item->action_id
            ];

            $product_item_struct = [
                'barcode' => $item->item->barcode
            ];

            $item_struct['item'] = $product_item_struct;

            if ($item->change) {
                $item_struct['change'] = [
                    'comment' => $item->change->comment
                ];
            }

            $form_params['items'][$item_key] = $item_struct;
        }

        return [
            'form_params' => $form_params
        ];
    }
}
