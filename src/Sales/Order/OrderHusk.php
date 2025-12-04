<?php

namespace Flyokai\MagentoDto\Sales;

use Flyokai\DataMate\Helper\DtoTrait;

class OrderHusk
{
    use DtoTrait;

    public function __construct(
        public readonly \Flyokai\MagentoDto\Sales\Order $order,
        public readonly array                            $isSeparatePoFlags,
        public readonly array                            $isSeparateShipmentFlags,
        public readonly array                            $isShipSeparatelyFlags,
        public readonly array                            $isDummy,
        public readonly array                            $isShipDummy,
        public readonly array                            $canPoItemFlags,
    )
    {
    }

    public function isSeparateShipment(\Flyokai\MagentoDto\Sales\Order\Item $item): bool
    {
        return $this->isSeparateShipmentFlags[$item->id()] ?? false;
    }

    public function isSeparatePo(\Flyokai\MagentoDto\Sales\Order\Item $item): bool
    {
        return $this->isSeparatePoFlags[$item->id()] ?? false;
    }

    public function isShipSeparately(\Flyokai\MagentoDto\Sales\Order\Item $item): bool
    {
        return $this->isShipSeparatelyFlags[$item->id()] ?? false;
    }

    public function isDummy(\Flyokai\MagentoDto\Sales\Order\Item $item): bool
    {
        return $this->isDummy[$item->id()] ?? false;
    }

    public function isShipDummy(\Flyokai\MagentoDto\Sales\Order\Item $item): bool
    {
        return $this->isShipDummy[$item->id()] ?? false;
    }

    public function getOrderItemQtyToUdpo(\Flyokai\MagentoDto\Sales\Order\Item $orderItem, bool $skipDummy = false): int
    {
        if ($this->isShipDummy($orderItem) && !$skipDummy) {
            return 0;
        }
        $qty = $orderItem->getQtyOrdered()
            - $orderItem->getQtyUdpo()
            - $orderItem->getQtyRefunded()
            - $orderItem->getQtyCanceled();
        return max($qty, 0);
    }

    public function getQtyToShip(\Flyokai\MagentoDto\Sales\Order\Item $orderItem)
    {
        if ($this->isShipDummy($orderItem)) {
            return 0;
        }
        $qty = $orderItem->getQtyOrdered()
            - max($orderItem->getQtyShipped(), $orderItem->getQtyRefunded())
            - $orderItem->getQtyCanceled();
        return max(round($qty, 8), 0);
    }

    public function canPoItem(\Flyokai\MagentoDto\Sales\Order\Item $item): bool
    {
        return $this->canPoItemFlags[$item->id()] ?? false;
    }
}
