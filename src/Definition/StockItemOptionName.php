<?php

namespace Flyokai\MagentoDto\Definition;

enum StockItemOptionName: string
{
    use \Flyokai\DataMate\Helper\StringEnumTrait;

    case MinQty = 'min_qty';
    case MinSaleQty = 'min_sale_qty';
    case MaxSaleQty = 'max_sale_qty';
    case Backorders = 'backorders';
    case NotifyStockQty = 'notify_stock_qty';
    case ManageStock = 'manage_stock';
    case EnableQtyIncrements = 'enable_qty_increments';
    case QtyIncrements = 'qty_increments';
    case AutoReturn = 'auto_return';
}
