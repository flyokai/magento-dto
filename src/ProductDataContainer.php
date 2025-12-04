<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Helper\DtoTrait;

class ProductDataContainer
{
    use DtoTrait;

    /**
     * @var array<int, ProductData>
     */
    private array $byRowId = [];
    /**
     * @var array<int, ProductData>
     */
    private array $bySeqId = [];
    /**
     * @var array<string, ProductData>
     */
    private array $bySku = [];

    /**
     * @param ProductData[] $products
     */
    public function __construct(
        public readonly array $products,
        public readonly string $skuField = 'sku',
        public readonly string $seqIdField = 'entity_id',
        public readonly string $rowIdField = 'entity_id',
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        foreach ($this->products as $product) {
            if ($sku = $product->getValue($this->skuField)) {
                $this->bySku[$sku] = $product;
            }
            if ($seqId = $product->getValue($this->seqIdField)) {
                $this->bySeqId[$seqId] = $product;
            }
            if ($rowId = $product->getValue($this->rowIdField)) {
                $this->byRowId[$rowId] = $product;
            }
        }
    }

    public function __wakeup(): void
    {
        $this->initialize();
    }

    public function getByRowId(int $key): ?ProductData
    {
        return $this->byRowId[$key]??null;
    }

    public function getBySeqId(int $key): ?ProductData
    {
        return $this->bySeqId[$key]??null;
    }

    public function getBySku(string $sku): ?ProductData
    {
        return $this->bySku[$sku]??null;
    }

    /**
     * @return array<string, ProductData>
     */
    public function bySku(): array
    {
        return $this->bySku;
    }

    /**
     * @return array<int, ProductData>
     */
    public function byRowId(): array
    {
        return $this->byRowId;
    }

    /**
     * @return array<int, ProductData>
     */
    public function bySeqId(): array
    {
        return $this->bySeqId;
    }

    /**
     * @return array<string, ProductData>
     */
    public function byUrlPath(): array
    {
        return $this->bySku;
    }
}
