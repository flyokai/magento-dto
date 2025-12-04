<?php

namespace Flyokai\MagentoDto\Cart;

use Flyokai\DataMate\GreyData;

interface CartItem extends GreyData
{
    public function hashId(): int;
}
