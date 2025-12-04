<?php

namespace Flyokai\MagentoDto\Product;

use Flyokai\DataMate\Helper\DtoTrait;
use Flyokai\MagentoDto\Product\Attribute\OptionContainer;

class Attribute
{
    use DtoTrait;

    /**
     * @param OptionContainer|null $optionContainer
     */
    public function __construct(
        public readonly int|string       $attribute_id,
        public readonly string           $attribute_code,
        public readonly ?string          $type,
        public readonly mixed            $default_value,
        public readonly array            $data,
        public readonly ?OptionContainer $optionContainer,
        public readonly bool             $required = false,
        public readonly ?string          $force_field = null,
        public readonly ?string          $force_value = null,
        public readonly array            $attribute_set_ids = []
    )
    {
    }

    public function appliesTo(string $typeId): bool
    {
        return ($this->data['apply_to'][$typeId] ?? false)
            || empty($this->data['apply_to'] ?? []);
    }

    public function isInSet(string $setId): bool
    {
        return in_array($setId, $this->attribute_set_ids);
    }

    public function getIsGlobal(): int
    {
        return $this->data['is_global'] ?? AttributeContainer::SCOPE_GLOBAL;
    }

    public function isGlobal(): bool
    {
        return $this->getIsGlobal() == AttributeContainer::SCOPE_GLOBAL;
    }

    public function isWebsite(): bool
    {
        return $this->getIsGlobal() == AttributeContainer::SCOPE_WEBSITE;
    }

    public function isStore(): bool
    {
        return $this->getIsGlobal() == AttributeContainer::SCOPE_STORE;
    }

    public function isSelectable(): bool
    {
        return in_array($this->frontendInput(), ['select', 'multiselect'])
            || ($this->data['source_model'] ?? false);
    }

    public function frontendInput(): string
    {
        return $this->data['frontend_input'] ?? 'text';
    }

    public function backendType(): ?string
    {
        return $this->data['backend_type'] ?? null;
    }
}
