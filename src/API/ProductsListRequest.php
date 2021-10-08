<?php
namespace Outofbox\OutofboxSDK\API;

class ProductsListRequest extends AbstractRequest
{
    const URI = '_api/private/v2/products';
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
     * @var bool|null
     */
    protected $in_stock;

    /**
     * @var int[]
     */
    protected $stocks = [];

    /**
     * Image sizes
     *
     * @var array
     */
    protected $images_sizes = [
        'small' => [
            'fs' => 'ofb-small',
            'filecpd' => [
                'type' => 'custom',
                'width' => 80,
                'height' => 80,
                'crop' => true
            ]
        ]
    ];

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
     * @param bool|null $in_stock
     * @return $this
     */
    public function setInStock($in_stock)
    {
        $this->in_stock = $in_stock;
        return $this;
    }

    /**
     * @param int $store_id
     * @return $this
     */
    public function setStock($store_id)
    {
        return $this->setStocks([ $store_id ]);
    }

    /**
     * @param int[] $stocks
     * @return $this
     */
    public function setStocks($stocks)
    {
        $this->stocks = $stocks;
        return $this;
    }

    /**
     * @return array
     */
    public function getImagesSizes()
    {
        return $this->images_sizes;
    }

    /**
     * @param array $images_sizes
     * @return $this
     */
    public function setImagesSizes(array $images_sizes)
    {
        $this->images_sizes = $images_sizes;
        return $this;
    }

    /**
     * @param string $size_key
     * @param array $size_params
     * @return $this
     */
    public function addImageSize($size_key, array $size_params)
    {
        $this->images_sizes[$size_key] = $size_params;
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

        if ($this->in_stock !== null) {
            $query_params['in_stock'] = $this->in_stock;
        } else if ($this->stocks) {
            $query_params['stock'] = $this->stocks;
        }

        if ($this->images_sizes) {
            $query_params['images_modifications'] = $this->images_sizes;
        }

        return [
            'query' => $query_params
        ];
    }
}