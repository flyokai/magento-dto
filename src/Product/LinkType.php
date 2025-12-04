<?php

namespace Flyokai\MagentoDto\Product;

use Flyokai\DataMate\Helper\DtoTrait;

class LinkType
{
    use DtoTrait;

    /**
     * @param LinkTypeAttribute[] $attributes
     */
    public function __construct(
        public readonly int $id,
        public readonly string $code,
        public readonly array $attributes = [],
    )
    {
    }
}
