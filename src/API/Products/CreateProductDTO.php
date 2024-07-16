<?php

namespace Outofbox\OutofboxSDK\API\Products;

class CreateProductDTO
{
    public int $type_id;
    public string $title;
    public string $description;
    public array $fields;

    public function __construct(int $type_id, string $title, string $description = '', array $fields = [])
    {
        $this->type_id = $type_id;
        $this->title = $title;
        $this->description = $description;
        $this->fields = $fields;
    }
}
