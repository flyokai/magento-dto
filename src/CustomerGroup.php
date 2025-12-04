<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Helper\DtoTrait;

class CustomerGroup
{
    use DtoTrait;

    public function __construct(
        public readonly int $id,
        public readonly string $code,
        public readonly int $taxClassId,
    )
    {
    }
}
