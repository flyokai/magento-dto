<?php

namespace Flyokai\MagentoDto\Cart;

use Flyokai\DataMate\Helper\DtoTrait;
use Flyokai\DataMate\Helper\JarTrait;

/**
 * @implements \Flyokai\DataMate\ItemJar<RateMethod|RateError>
 */
class RateResult implements \Flyokai\DataMate\ItemJar
{
    use DtoTrait;
    /** @use JarTrait<RateMethod|RateError> */
    use JarTrait;

    private array $byId = [];

    /**
     * @param RateMethod|RateError[] $items
     */
    public function __construct(
        public readonly array $items = [],
        public readonly bool  $error = false,
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        foreach ($this->items as $rate) {
            $id = $rate->id();
            if ($id !== null) {
                $this->byId[$id] = $rate;
            }
        }
    }

    public function __wakeup(): void
    {
        $this->initialize();
    }

    public function append(RateItem|RateResult|array $result): self
    {
        $error = $this->error;
        $rates = $this->items;
        if ($result instanceof RateItem) {
            $rates = array_merge($this->items, [$result]);
            if ($result instanceof RateError) {
                $error = true;
            }
        } elseif ($result instanceof RateResult || is_array($result)) {
            if ($result instanceof RateResult) {
                $result = $result->items;
            }
            $error = array_reduce($result, fn ($e, $i) => $e || $i instanceof RateError, $error);
            $rates = array_merge($this->items, $result);
        }
        return $this->cloneWith(error: $error, items: $rates);
    }

}
