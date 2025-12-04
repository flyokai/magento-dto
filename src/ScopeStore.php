<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Helper\DtoTrait;

class ScopeStore
{
    use DtoTrait;

    public function __construct(
        public readonly int    $store_id,
        public readonly string $code,
        public readonly string $name,
        public readonly int    $group_id,
        public readonly int    $website_id,
        public readonly int    $is_active,
        public readonly string $base_url,
    )
    {

    }

}
