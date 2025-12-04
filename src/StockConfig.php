<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Dto\ConfigJar;
use Flyokai\DataMate\Helper\DtoTrait;
use Flyokai\MagentoDto\Definition\StockItemOptionName;
use Flyokai\MagentoDto\Definition\StockOptionName;

class StockConfig
{
    use DtoTrait;

    public function __construct(
        public readonly ConfigJar $configJar,
        public readonly ConfigJar $itemConfigJar,
        public readonly array $isQtyTypeIds,
        public readonly array $customerMinSaleQty,
    )
    {
    }

    public function isQty(string $typeId): bool
    {
        return $this->isQtyTypeIds[$typeId] ?? false;
    }

    public function canSubtractQty(): bool
    {
        return (bool)$this->configJar->get(StockOptionName::CanSubtract->value);
    }

    public function minQty(): float
    {
        return (float)$this->itemConfigJar->get(StockItemOptionName::MinQty->value);
    }

    public function minSaleQty(?int $customerGroupId = null): float
    {
        return (float)$this->customerMinSaleQty[$customerGroupId];
    }

    public function maxSaleQty()
    {
        return (float)$this->itemConfigJar->get(StockItemOptionName::MaxSaleQty->value);
    }

    public function notifyStockQty(): float
    {
        return (float)$this->itemConfigJar->get(StockItemOptionName::NotifyStockQty->value);
    }

    public function enableQtyIncrements(): bool
    {
        return (bool)$this->itemConfigJar->get(StockItemOptionName::EnableQtyIncrements->value);
    }

    public function qtyIncrements(): float
    {
        return (float)$this->itemConfigJar->get(StockItemOptionName::QtyIncrements->value);
    }

    public function backorders(): int
    {
        return (int)$this->itemConfigJar->get(StockItemOptionName::Backorders->value);
    }

    public function manageStock(): bool
    {
        return (bool)$this->itemConfigJar->get(StockItemOptionName::Backorders->value);
    }

    public function canBackInStock(): bool
    {
        return (bool)$this->configJar->get(StockOptionName::CanBackInStock->value);
    }

    public function isShowOutOfStock(): bool
    {
        return (bool)$this->configJar->get(StockOptionName::ShowOutOfStock->value);
    }

    public function isAutoReturnEnabled(): bool
    {
        return (bool)$this->itemConfigJar->get(StockItemOptionName::AutoReturn->value);
    }

    public function isDisplayProductStockStatus(): bool
    {
        return (bool)$this->configJar->get(StockOptionName::DisplayProductStockStatus->value);
    }

    public function defaultConfigValue(string $field): mixed
    {
        $tryStorage = new \SplObjectStorage;
        $tryStorage[$this->configJar] = StockOptionName::tryFromValue(...);
        $tryStorage[$this->itemConfigJar] = StockItemOptionName::tryFromValue(...);
        $tryStorage->rewind();
        while ($tryStorage->valid()) {
            $configJar = $tryStorage->current();
            $tryFrom = $tryStorage->getInfo();
            if (null !== ($optionName = $tryFrom($field))) {
                return $configJar->get($optionName->value);
            }
            $tryStorage->next();
        }
        return null;
    }

    public function stockThresholdQty(): float
    {
        return (float)$this->configJar->get(StockOptionName::StockThresholdQty->value);
    }
}
