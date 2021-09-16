<?php
namespace Outofbox\OutofboxSDK\Model;

class Image
{
    /**
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    public $modifications = [];

    /**
     * @param string $modification_key
     * @return string|null
     */
    public function getUrl($modification_key)
    {
        if (!isset($this->modifications[$modification_key])) {
            return null;
        }

        return $this->modifications[$modification_key];
    }
}