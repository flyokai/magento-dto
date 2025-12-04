<?php

namespace Flyokai\MagentoDto\Cart\Quote;

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
                $this->fragile || throw new \ValueError("Cart quote item id cannot be 0|null");
            } else {
                $this->byId[$id] = $item;
            }
            if (0 < ($piId = (int)$item->get('parent_item_id'))) {
                $this->byParentItemId[$piId] = $item;
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
}
