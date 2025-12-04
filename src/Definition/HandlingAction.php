<?php

namespace Flyokai\MagentoDto\Definition;

use Flyokai\DataMate\Helper\StringEnumTrait;

enum HandlingAction: string
{
    use StringEnumTrait;

    case Package = 'P';
    case Order = 'O';
}
