<?php

namespace Flyokai\MagentoDto\Sales\Order;

use Flyokai\DataMate\Helper\DtoTrait;
use Flyokai\DataMate\Helper\JarTrait;

/**
 * @implements \Flyokai\DataMate\ItemJar<Item>
 */
class ItemJar implements \Flyokai\DataMate\ItemJar
{
    use DtoTrait;
    /** @use JarTrait<Item> */
    use JarTrait;

    private array $byId = [];
    private array $byParentItemId = [];
    private array $byQuoteItemId = [];

    /**
     * @param Item[] $items
     * @param \SplObjectStorage<Item, Item> $parentItems
     * @param \SplObjectStorage<Item, Item[]> $childItems
     */
    public function __construct(
        public readonly array             $items,
        public readonly \SplObjectStorage $parentItems,
        public readonly \SplObjectStorage $childItems,
        public readonly bool              $fragile,
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        foreach ($this->items as $item) {
            $id = (int)($item->id());
            if ($id === 0) {
                $this->fragile || throw new \ValueError("Sales order item id cannot be 0|null");
            } else {
                $this->byId[$id] = $item;
            }
            if (0 < ($piId = (int)$item->get('parent_item_id'))) {
                $this->byParentItemId[$piId] = $item;
            }
            if (0 < ($qiId = (int)$item->get('quote_item_id'))) {
                $this->byQuoteItemId[$qiId] = $item;
            }
        }
    }

    public function __wakeup(): void
    {
        $this->initialize();
    }

    public function byParentItemId(): array
    {
        return $this->byParentItemId;
    }

    public function byQuoteItemId(): array
    {
        return $this->byQuoteItemId;
    }

    public function hasChildItems(Item $parentItem): bool
    {
        return $this->childItems->contains($parentItem);
    }

    public function getChildItems(Item $parentItem): array
    {
        return $this->childItems[$parentItem] ?? [];
    }

    public function hasParentItem(Item $parentItem): bool
    {
        return $this->parentItems->contains($parentItem);
    }

    public function getParentItem(Item $parentItem): ?Item
    {
        return $this->parentItems[$parentItem] ?? null;
    }

    public function needToAddDummy(Item $item, array $qtys = []): bool
    {
        if ($this->hasChildItems($item)) {
            $children = $this->getChildItems($item);
            foreach ($children as $child) {
                if (empty($qtys)) {
                    if ($child->getQtyToShip() > 0) {
                        return true;
                    }
                } else {
                    if (($qtys[$child->getId()] ?? 0) > 0) {
                        return true;
                    }
                }
            }
        } elseif (($parent = $this->getParentItem($item))) {
            if (empty($qtys)) {
                if ($parent->getQtyToShip() > 0) {
                    return true;
                }
            } else {
                if (($qtys[$parent->getId()] ?? 0) > 0) {
                    return true;
                }
            }
        }
        return false;
    }
}
