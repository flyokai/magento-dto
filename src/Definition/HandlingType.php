<?php

namespace Flyokai\MagentoDto\Definition;

use Flyokai\DataMate\Helper\StringEnumTrait;

enum HandlingType: string
{
    use StringEnumTrait;

    case Percent = 'P';
    case Fixed = 'F';
}
