<?php

namespace Flyokai\MagentoDto\Product\Attribute;

use Flyokai\DataMate\Helper\DtoTrait;

class Option
{
    use DtoTrait;

    public function __construct(
        public readonly int|string $value,
        public readonly string $label,
    )
    {
    }
}
