<?php

namespace Flyokai\MagentoDto\Cart\Quote;

use Flyokai\DataMate\Helper\DtoTrait;
use Flyokai\DataMate\Helper\JarTrait;

/**
 * @implements \Flyokai\DataMate\ItemJar<Address>
 */
class AddressJar implements \Flyokai\DataMate\ItemJar
{
    use DtoTrait;
    /** @use JarTrait<Address> */
    use JarTrait;

    private array $byId = [];
    private array $byParentItemId = [];

    /**
     * @param Address[] $items
     */
    public function __construct(
        public readonly array $items,
        public readonly bool  $fragile,
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        foreach ($this->items as $item) {
            $id = (int)($item->id());
            if ($id === 0) {
                $this->fragile || throw new \ValueError("Cart quote address id cannot be 0|null");
            } else {
                $this->byId[$id] = $item;
            }
        }
    }

    public function __wakeup(): void
    {
        $this->initialize();
    }

}
