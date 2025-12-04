<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Helper\DtoTrait;

class Category
{
    use DtoTrait;

    /**
     * @param string[] $name_path
     */
    public function __construct(
        public readonly int $row_id,
        public readonly int $entity_id,
        public readonly ?int $parent_id,
        public readonly string $name,
        public readonly string $path,
        public readonly ?string $url_key,
        public readonly ?string $url_path,
        public readonly ?array $name_path,
        public readonly int $level=0,
        public readonly int $position=0,
        public int $children_max_pos=0,
        public int $children_count=0,
    )
    {
    }

    public function namePath(string $delimiter): string
    {
        return implode($delimiter, $this->name_path);
    }
}
