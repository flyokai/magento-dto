<?php

namespace Flyokai\MagentoDto\Definition;

use Flyokai\DataMate\Helper\StringEnumTrait;

enum ProductType: string
{
    use StringEnumTrait;

    case Simple = 'simple';
    case Configurable = 'configurable';
    case Grouped = 'grouped';
    case Virtual = 'virtual';
    case Bundle = 'bundle';
    case Downloadable = 'downloadable';
}
