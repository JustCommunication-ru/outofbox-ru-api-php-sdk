<?php

namespace Outofbox\OutofboxSDK\Model;

class ShopOrder
{
    /**
     * @var string
     */
    protected $number;

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return ShopOrder
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }
}
