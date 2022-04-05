<?php
namespace Outofbox\OutofboxSDK\API\Categories;

use Outofbox\OutofboxSDK\API\AbstractRequest;

class CategoriesListRequest extends AbstractRequest
{
    const URI = '/_api/private/products-categories';
    const RESPONSE_CLASS = CategoriesListResponse::class;

    /**
     * @var int|null
     */
    protected $parent_id;

    /**
     * @var int|null
     */
    protected $status;

    /**
     * CategoriesListRequest constructor.
     * @param null $parent_id
     */
    public function __construct($parent_id = null)
    {
        $this->setParentId($parent_id);
    }

    /**
     * @param int|null $parent_id
     * @return $this
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     * @return CategoriesListRequest
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function createHttpClientParams()
    {
        $query_params = [];

        if ($this->parent_id) {
            $query_params['parent_id'] = $this->parent_id;
        }

        if ($this->status !== null) {
            $query_params['status'] = $this->status;
        }

        return [
            'query' => $query_params
        ];
    }
}