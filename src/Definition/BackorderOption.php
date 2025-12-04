<?php

namespace Flyokai\MagentoDto\Definition;

enum BackorderOption: int
{
    case UseConfig = -1;
    case No = 0;
    case YesNoNotify = 1;
    case YesNotify = 2;
}
