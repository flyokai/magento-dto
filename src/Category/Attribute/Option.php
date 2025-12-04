<?php

namespace Flyokai\MagentoDto\Category\Attribute;

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
