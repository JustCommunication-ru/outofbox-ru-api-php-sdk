<?php

namespace Outofbox\OutofboxSDK\API\Categories;

use Outofbox\OutofboxSDK\API\AbstractResponse;
use Outofbox\OutofboxSDK\Model\Category;

class CategoriesListResponse extends AbstractResponse
{
    /**
     * @var Category[]
     */
    protected $categories;

    /**
     * CategoriesListResponse constructor.
     * @param Category[] $categories
     */
    public function __construct(array $categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
