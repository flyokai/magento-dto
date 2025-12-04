<?php

namespace Flyokai\MagentoDto\Product;

use Flyokai\DataMate\Helper\DtoTrait;

class LinkTypeAttribute
{
    use DtoTrait;

    public function __construct(
        public readonly int $id,
        public readonly string $code,
        public readonly string $data_type,
    )
    {
    }
}
