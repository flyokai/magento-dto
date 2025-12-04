<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Helper\DtoTrait;

class CategoryDataContainer
{
    use DtoTrait;

    /**
     * @var array<int, CategoryData>
     */
    private array $byRowId = [];
    /**
     * @var array<int, CategoryData>
     */
    private array $bySeqId = [];
    /**
     * @var array<string, CategoryData>
     */
    private array $byUrlPath = [];

    /**
     * @param CategoryData[] $categories
     */
    public function __construct(
        public readonly array $categories,
        public readonly string $urlPathField = 'url_path',
        public readonly string $seqIdField = 'entity_id',
        public readonly string $rowIdField = 'entity_id',
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        foreach ($this->categories as $category) {
            if ($urlPath = $category->getValue($this->urlPathField)) {
                $this->byUrlPath[$urlPath] = $category;
            }
            if ($seqId = $category->getValue($this->seqIdField)) {
                $this->bySeqId[$seqId] = $category;
            }
            if ($rowId = $category->getValue($this->rowIdField)) {
                $this->byRowId[$rowId] = $category;
            }
        }
    }

    public function __wakeup(): void
    {
        $this->initialize();
    }

    public function getByRowId(int $key): ?CategoryData
    {
        return $this->byRowId[$key]??null;
    }

    public function getBySeqId(int $key): ?CategoryData
    {
        return $this->bySeqId[$key]??null;
    }

    public function getByUrlPath(string $urlPath): ?CategoryData
    {
        return $this->byUrlPath[$urlPath]??null;
    }

    /**
     * @return array<string, CategoryData>
     */
    public function byUrlPath(): array
    {
        return $this->byUrlPath;
    }

    /**
     * @return array<int, CategoryData>
     */
    public function byRowId(): array
    {
        return $this->byRowId;
    }

    /**
     * @return array<int, CategoryData>
     */
    public function bySeqId(): array
    {
        return $this->bySeqId;
    }
}
