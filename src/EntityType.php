<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Helper\DtoTrait;

class EntityType
{
    use DtoTrait;

    public function __construct(
        public readonly int $entity_type_id,
        public readonly string $entity_type_code,
        public readonly string $entity_table,
        public readonly ?int $default_attribute_set_id = null,
    )
    {
    }

    public function id(): int
    {
        return $this->entity_type_id;

    }
    public function code(): string
    {
        return $this->entity_type_code;
    }
}
