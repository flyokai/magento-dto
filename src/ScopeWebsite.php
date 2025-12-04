<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Helper\DtoTrait;

class ScopeWebsite
{
    use DtoTrait;
    public function __construct(
        public readonly int    $website_id,
        public readonly string $code,
        public readonly string $name,
        public readonly int    $default_group_id,
    )
    {
    }
}
