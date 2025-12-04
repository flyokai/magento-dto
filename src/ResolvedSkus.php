<?php

namespace Flyokai\MagentoDto;

class ResolvedSkus
{
    use \Flyokai\DataMate\Helper\DtoTrait;

    public function __construct(
        public readonly array $resolvedSkus,
        public readonly bool $isCaseSensitive = false,
    )
    {
    }

    private \Closure $skuCmp;
    private function skuCmp(): \Closure
    {
        return $this->skuCmp ??= $this->isCaseSensitive
            ? static function ($a, $b) { return (string)$a === (string)$b; }
            : static function ($a, $b) { return strtolower((string)$a) === strtolower((string)$b); }
        ;
    }

    public function hasSkus(string $sku): bool
    {
        return $this->rowIdBySku($sku) !== null;
    }

    public function skus(): array
    {
        return array_keys($this->resolvedSkus);
    }

    private array $rowIds;
    public function rowIds(): array
    {
        return $this->rowIds ??= array_map(fn ($value) => is_array($value) ? $value[0] : $value, $this->resolvedSkus);
    }

    private array $entityIds;
    public function entityIds(): array
    {
        return $this->entityIds ??= array_map(fn ($value) => is_array($value) ? $value[1] : $value, $this->resolvedSkus);
    }

    private array $rowIdsToEntityIds;
    public function rowIdsToEntityIds(): array
    {
        return $this->rowIdsToEntityIds ??= array_combine(
            $this->rowIds(),
            $this->entityIds(),
        );
    }

    private array $entityIdsToRowIds;
    public function entityIdsToRowIds(): array
    {
        return $this->entityIdsToRowIds ??= array_combine(
            $this->entityIds(),
            $this->rowIds(),
        );
    }

    public function rowIdBySku(string $sku): ?int
    {
        return $this->idBySku($sku, 0);
    }

    public function entityIdBySku(string $sku): ?int
    {
        return $this->idBySku($sku, 1);
    }

    private function idBySku(string $sku, int $index): ?int
    {
        $value = array_reduce(
            array_filter($this->resolvedSkus,
                fn ($value, $key) => ($this->skuCmp())($key, $sku),
                ARRAY_FILTER_USE_BOTH
            ),
            fn ($carry, $value) => $value
        );
        return is_array($value) ? $value[$index] : $value ?? null;
    }

}
