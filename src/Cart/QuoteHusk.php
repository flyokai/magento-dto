<?php

namespace Flyokai\MagentoDto\Cart;

use Flyokai\DataMate\Dto;
use Flyokai\DataMate\Helper\DtoTrait;

class QuoteHusk implements Dto
{
    use DtoTrait;

    public function __construct(
        public readonly Quote $quote,
    )
    {
    }

}
