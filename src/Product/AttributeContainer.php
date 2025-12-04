<?php

namespace Flyokai\MagentoDto\Product;

use Flyokai\DataMate\Helper\DtoTrait;
use Flyokai\MagentoDto\Product\Attribute\Option;

class AttributeContainer
{
    use DtoTrait;

    public const BUNDLE_TOGETHER = 0;
    public const BUNDLE_SEPARATELY = 1;
    public const BUNDLE_FIXED = 1;
    public const BUNDLE_DYNAMIC = 0;

    public const CODE_ATTRIBUTE_SET = 'product.attribute_set';
    public const CODE_TYPE_ID = 'product.type';
    public const CODE_HAS_OPTIONS = 'product.has_options';
    public const CODE_REQUIRED_OPTIONS = 'product.required_options';
    public const CODE_CATEGORY_IDS = 'category.ids';
    public const CODE_CATEGORY_PATH = 'category.path';
    public const CODE_CATEGORY_NAME = 'category.name';
    public const CODE_CATEGORY_POSITION = 'category.position';
    public const CODE_WEBSITES = 'product.websites';

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
