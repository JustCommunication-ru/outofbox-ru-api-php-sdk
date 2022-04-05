<?php
namespace Outofbox\OutofboxSDK\Model;

class Category
{
    const STATUS_NORMAL = 1;
    const STATUS_HIDDEN = 2;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array|string[]
     */
    protected $title_path;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var bool
     */
    protected $is_final;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Category
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Category
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return array|string[]
     */
    public function getTitlePath()
    {
        return $this->title_path;
    }

    /**
     * @param array|string[] $title_path
     * @return Category
     */
    public function setTitlePath($title_path)
    {
        $this->title_path = $title_path;
        return $this;
    }

    /**
     * @param string $separator
     * @return string
     */
    public function getFullTitle($separator = ' / ')
    {
        return implode($separator, $this->title_path);
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Category
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function isHidden()
    {
        return $this->status === self::STATUS_HIDDEN;
    }

    /**
     * @return bool
     */
    public function isIsFinal()
    {
        return $this->is_final;
    }

    /**
     * @param bool $is_final
     * @return Category
     */
    public function setIsFinal($is_final)
    {
        $this->is_final = $is_final;
        return $this;
    }
}