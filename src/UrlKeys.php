<?php

namespace Flyokai\MagentoDto;

class UrlKeys
{
    use \Flyokai\DataMate\Helper\DtoTrait;

    public function __construct(
        public readonly array $resolvedUrlKeys,
        public readonly bool  $isCaseSensitive = false,
    )
    {
    }

    private \Closure $urlKeyCmp;
    private function urlKeyCmp(): \Closure
    {
        return $this->urlKeyCmp ??= $this->isCaseSensitive
            ? static function ($a, $b) { return (string)$a === (string)$b; }
            : static function ($a, $b) { return strtolower((string)$a) === strtolower((string)$b); }
            ;
    }

    public function urlKeys(): array
    {
        return array_keys($this->resolvedUrlKeys);
    }

    private array $rowIds;
    public function rowIds(): array
    {
        return $this->rowIds ??= array_map(fn ($value) => is_array($value) ? $value[0] : $value, $this->resolvedUrlKeys);
    }

    private array $entityIds;
    public function entityIds(): array
    {
        return $this->entityIds ??= array_map(fn ($value) => is_array($value) ? $value[1] : $value, $this->resolvedUrlKeys);
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
        return $this->rowIdsToEntityIds ??= array_combine(
            $this->entityIds(),
            $this->rowIds(),
        );
    }

    public function rowIdByUrlKey(string $urlKey): ?int
    {
        return $this->idByUrlKey($urlKey, 0);
    }

    public function entityIdByUrlKey(string $urlKey): ?int
    {
        return $this->idByUrlKey($urlKey, 1);
    }

    private function idByUrlKey(string $urlKey, int $index): ?int
    {
        $result = array_filter($this->resolvedUrlKeys,
            fn ($value, $key) => ($this->urlKeyCmp())($value, $urlKey),
            ARRAY_FILTER_USE_BOTH
        );
        $value = count($result) ? current($result) : null;
        return is_array($value) ? $value[$index] : $value ?? null;
    }
}
