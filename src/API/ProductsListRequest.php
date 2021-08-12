<?php
namespace Outofbox\OutofboxSDK\API;

class ProductsListRequest extends AbstractRequest
{
    const URI = '/_api/private/v2/products';
    const RESPONSE_CLASS = ProductsListResponse::class;

    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var int
     */
    protected $per_page = 20;

    /**
     * @param int $page
     * @return ProductsListRequest
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @param int $per_page
     * @return ProductsListRequest
     */
    public function setPerPage($per_page)
    {
        $this->per_page = $per_page;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function createHttpClientParams()
    {
        return [
            'query' => [
                'page' => $this->page,
                'per_page' => $this->per_page
            ]
        ];
    }
}