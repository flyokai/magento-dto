<?php

namespace Flyokai\MagentoDto\Category;

use Flyokai\DataMate\Helper\DtoTrait;
use Flyokai\MagentoDto\Category\Attribute\Option;

class AttributeContainer
{
    use DtoTrait;

    public const SCOPE_STORE = 0;
    public const SCOPE_GLOBAL = 1;
    public const SCOPE_WEBSITE = 2;

    /**
     * @var array<int|string, Attribute>
     */
    private array $byId = [];
    /**
     * @var array<string, Attribute>
     */
    private array $byCode = [];
    /**
     * @var Attribute
     */
    private array $byType = [];
    /**
     * @var Attribute
     */
    private array $bySetId = [];

    /**
     * @var array<int, Attribute>
     */
    private array $websiteScope = [];

    /**
     * @param Attribute[] $attributes
     */
    public function __construct(
        public readonly array $attributes,
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        $this->byId = $this->byCode = $this->byType = $this->websiteScope = $this->bySetId = [];
        foreach ($this->attributes as $attribute) {
            $aId = $attribute->attribute_id;
            $aCode = $attribute->attribute_code;
            $aSetIds = $attribute->attribute_set_ids;
            $aType = $attribute->type;
            $this->byId[$aId] = $attribute;
            $this->byCode[$aCode] = $attribute;
            if ($aType) {
                $this->byType[$aType][$aId] = $attribute;
            }
            if ($attribute->getIsGlobal() == AttributeContainer::SCOPE_WEBSITE) {
                $this->websiteScope[$aId] = $attribute;
            }
            foreach ($aSetIds as $aSetId) {
                $this->bySetId[$aSetId][] = $attribute;
            }
        }
    }

    public function __wakeup(): void
    {
        $this->initialize();
    }

    public function get(int|string $identifier): ?Attribute
    {
        if (isset($this->byId[$identifier])) {
            return $this->byId[$identifier];
        } elseif (isset($this->byCode[$identifier])) {
            return $this->byCode[$identifier];
        } else {
            return null;
        }
    }

    public function getField(int|string $identifier, string $field): mixed
    {
        return $this->get($identifier)?->data[$field]??null;
    }

    public function getOption(int|string $identifier, int|string $value, bool $byText = true): ?Option
    {
        return $this->get($identifier)?->optionContainer?->get($value, $byText) ?? null;
    }

    /**
     * @var array<string|int, Attribute>
     */
    public function byId(): array
    {
        return $this->byId;
    }

    /**
     * @var array<string, Attribute>
     */
    public function byCode(): array
    {
        return $this->byCode;
    }

    /**
     * @var Attribute
     */
    public function byType(?string $type=null): array
    {
        return $type !== null
            ? $this->byType[$type] ?? []
            : $this->byType;
    }

    /**
     * @var Attribute
     */
    public function bySetId(?int $setId=null): array
    {
        return $setId !== null
            ? ($this->bySetId[$setId] ?? [])
            : $this->bySetId;
    }

    /**
     * @var array<int, Attribute>
     */
    public function websiteScope(): array
    {
        return $this->websiteScope;
    }
}
