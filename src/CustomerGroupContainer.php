<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Helper\DtoTrait;

class CustomerGroupContainer
{
    use DtoTrait;

    /**
     * @var array<int, CustomerGroup>
     */
    private array $byId;

    /**
     * @var array<string, CustomerGroup>
     */
    private array $byCode;

    /**
     * @param CustomerGroup[] $groups
     */
    public function __construct(
        public readonly array $groups,
        public readonly bool  $caseSensitive = false,
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        foreach ($this->groups as $group) {
            $this->byId[$group->id] = $group;
            $code = $group->code;
            if (!$this->caseSensitive) {
                $code = strtolower($code);
            }
            $this->byCode[$code] = $group;
        }
    }

    public function __wakeup(): void
    {
        $this->initialize();
    }

    public function getById(int|string $value): ?CustomerGroup
    {
        return $this->get($value, false);
    }

    public function getByCode(int|string $value): ?CustomerGroup
    {
        return $this->get($value, true);
    }

    public function get(int|string $identifier, ?bool $byCode = null): ?CustomerGroup
    {
        if ($byCode === null) {
            $byCode = !is_numeric($identifier);
        }
        if ($byCode) {
            $identifier = trim((string)$identifier);
            if (!$this->caseSensitive) {
                $identifier = strtolower($identifier);
            }
            return $this->byCode[$identifier] ?? null;
        } else {
            $identifier = (int)$identifier;
        }
        return $this->byId[$identifier] ?? null;
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
        if (!$this->caseSensitive) {
            $code = strtolower($code);
        }
        return $this->byCode[$code]?->id
            ?? ($safe ? false : throw new \RuntimeException(
                'Unknown customer group code %s', $code
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
        return $this->byId[$id]?->code
            ?? ($safe ? false : throw new \RuntimeException(
                'Unknown customer group id %d', $id
            ));
    }

    /**
     * @return array<int, CustomerGroup>
     */
    public function byId(): array
    {
        return $this->byId;
    }

    /**
     * @return array<string, CustomerGroup>
     */
    public function byCode(): array
    {
        return $this->byCode;
    }
}
