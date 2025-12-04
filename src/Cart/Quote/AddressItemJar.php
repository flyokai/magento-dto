<?php

namespace Flyokai\MagentoDto\Cart\Quote;

use Flyokai\DataMate\Helper\DtoTrait;
use Flyokai\DataMate\Helper\JarTrait;

/**
 * @implements \Flyokai\DataMate\ItemJar<AddressItem>
 */
class AddressItemJar implements \Flyokai\DataMate\ItemJar
{
    use DtoTrait;
    /** @use JarTrait<AddressItem> */
    use JarTrait;

    private array $byId = [];
    private array $byParentItemId = [];

    /**
     * @param AddressItem[] $items
     * @param \SplObjectStorage<AddressItem, AddressItem> $parentItems
     * @param \SplObjectStorage<AddressItem, AddressItem[]> $childItems
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

    public function hasChildItems(AddressItem $parentItem): bool
    {
        return $this->childItems->contains($parentItem);
    }

    public function getChildItems(AddressItem $parentItem): array
    {
        return $this->childItems[$parentItem] ?? [];
    }

    public function hasParentItem(AddressItem $parentItem): bool
    {
        return $this->parentItems->contains($parentItem);
    }

    public function getParentItem(AddressItem $parentItem): ?Item
    {
        return $this->parentItems[$parentItem] ?? null;
    }
}
