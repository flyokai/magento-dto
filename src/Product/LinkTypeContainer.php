<?php

namespace Flyokai\MagentoDto\Product;

use Flyokai\DataMate\Helper\DtoTrait;

class LinkTypeContainer
{
    use DtoTrait;

    /**
     * @var array<int, LinkType>
     */
    private array $byId = [];
    /**
     * @var array<string, LinkType>
     */
    private array $byCode = [];

    /**
     * @param LinkType[] $linkTypes
     */
    public function __construct(
        private array $linkTypes,
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        $this->byId = $this->byCode = [];
        foreach ($this->linkTypes as $linkType) {
            $this->byId[$linkType->id] = $linkType;
            $this->byCode[$linkType->code] = $linkType;
        }
    }

    public function __wakeup(): void
    {
        $this->initialize();
    }

    public function getById(int $id): ?LinkType
    {
        return $this->byId[$id] ?? null;
    }

    public function getByCode(string $code): ?LinkType
    {
        return $this->byCode[$code] ?? null;
    }

    public function byId(): array
    {
        return $this->byId;
    }

    public function byCode(): array
    {
        return $this->byCode;
    }

    public function linkTypes(): array
    {
        return $this->linkTypes;
    }
}
