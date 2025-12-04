<?php

namespace Flyokai\MagentoDto\Definition;

enum StockOptionName: string
{
    use \Flyokai\DataMate\Helper\StringEnumTrait;

    case StockThresholdQty = 'stock_threshold_qty';
    case DisplayProductStockStatus = 'display_product_stock_status';
    case ShowOutOfStock = 'show_out_of_stock';
    case CanSubtract  = 'can_subtract';
    case CanBackInStock = 'can_back_in_stock';
}
