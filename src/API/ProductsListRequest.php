<?php
namespace Outofbox\OutofboxSDK\API;

class ProductsListRequest extends AbstractRequest
{
    const URI = '/_api/private/v2/products';
    const RESPONSE_CLASS = ProductsListResponse::class;

    /**
     * Product type
     *
     * @var int
     */
    protected $type;

    /**
     * Search string
     *
     * @var string
     */
    protected $search;

    /**
     * Page
     *
     * @var int
     */
    protected $page = 1;

    /**
     * Item per page
     *
     * @var int
     */
    protected $per_page = 20;

    /**
     * Conditions
     *
     * @var array
     */
    protected $params = [];

    /**
     * @param string $search
     * @return $this
     */
    public function setSearch($search)
    {
        $this->search = $search;
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function addParams(array $params)
    {
        foreach ($this->params as $key => $value) {
            $this->addParam($key, $value);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearParams()
    {
        $this->params = [];
        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return ProductsListRequest
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param int $type
     * @return ProductsListRequest
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

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
        $query_params = $this->params;
        $query_params['page'] = $this->page;
        $query_params['per_page'] = $this->per_page;

        if ($this->type) {
            $query_params['type_id'] = $this->type;
        }

        if ($this->search) {
            $query_params['search'] = $this->search;
        }

        return [
            'query' => $query_params
        ];
    }
}