<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Helper\DtoTrait;

class EntityTypeContainer
{
    use DtoTrait;

    /**
     * @var array<int, \Flyokai\MagentoDto\Definition\EntityType>
     */
    private array $byId;

    /**
     * @param array<string, \Flyokai\MagentoDto\Definition\EntityType> $byCode
     */
    public function __construct(
        public readonly array $byCode,
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        foreach ($this->byCode as $entityType) {
            $id = $entityType->id();
            $this->byId[$id] = $entityType;
        }
    }

    public function __wakeup(): void
    {
        $this->initialize();
    }

    public function get(int|string $id): ?EntityType
    {
        return is_string($id)
            ? ($this->byCode[$id] ?? null)
            : ($this->byId[$id] ?? null);
    }

    public function getId(string $code): int|false
    {
        return $this->_id($code, true);
    }

    public function id(string $code): int
    {
        return $this->_id($code, false);
    }

    private function _id(string $code, bool $safe): int|false
    {
        return $this->byCode[$code]?->id()
            ?? ($safe ? false : throw new \RuntimeException(
                'Unknown entity type code %s', $code
            ));
    }

    public function getCode(int $id): string|false
    {
        return $this->_code($id, true);
    }

    public function code(int $id): string
    {
        return $this->_code($id, false);
    }

    public function _code(int $id, bool $safe): string|false
    {
        return $this->byId[$id]?->code()
            ?? ($safe ? false : throw new \RuntimeException(
                'Unknown entity type id %d', $id
            ));
    }
}
