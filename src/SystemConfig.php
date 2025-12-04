<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Helper\ArrayPath;
use Flyokai\DataMate\Helper\DtoTrait;
use Flyokai\MagentoDto\Definition\Feature;
use Flyokai\MagentoDto\Product\LinkTypeContainer;

class SystemConfig
{
    use DtoTrait;
    use ArrayPath;

    public function __construct(
        public readonly EntityTypeContainer    $entity_types,
        public readonly CustomerGroupContainer $customer_groups,
        public readonly LinkTypeContainer      $link_types,
        public readonly ScopeContainer         $scope_container,
        public readonly array                  $product_media_attributes,
        public readonly array                  $product_gallery_attributes,
        public readonly array                  $options,
        public readonly array                  $invOptions,
        public readonly mixed                  $locale,
        public readonly string                 $datetime_format,
        public readonly string                 $datetime_format_internal,
        public readonly bool                   $hasRowId,
        public readonly string                 $entityIdField,
        public readonly string                 $rowIdField,
        public readonly array                  $isQtyByTypeId,
        public readonly array                  $features,
        public readonly array                  $ddlTableColumns,
        public readonly array                  $translitConfig,
        public readonly bool                   $hasEeGwsFilter,
        public readonly array                  $allowedEeGwsWebsiteIds = [],
        public readonly array                  $allowedEeGwsStoreIds = [],
    )
    {
    }

    public function hasFeature(Feature $feature): bool
    {
        return $this->features[$feature->value] ?? false;
    }

    public function getOption(string $path, mixed $default = null): mixed
    {
        return $this->__fetchByPath($this->options, $path, $default);
    }

    public function setOption(string $path, mixed $value): static
    {
        $options = $this->__insertByPath($this->options, $path, $value);
        return $this->with(options: $options);
    }

    public function getInvOption(string $path, mixed $default = null): mixed
    {
        return $this->__fetchByPath($this->invOptions, $path, $default);
    }

    public function setInvOption(string $path, mixed $value): static
    {
        $options = $this->__insertByPath($this->invOptions, $path, $value);
        return $this->with(options: $options);
    }

    public function filterEeGwsStoreIds($sIds)
    {
        if ($this->hasEeGwsFilter) {
            return array_intersect($sIds, $this->allowedEeGwsStoreIds);
        }
        return $sIds;
    }

    public function filterEeGwsWebsiteIds($wIds)
    {
        if ($this->hasEeGwsFilter) {
            return array_intersect($wIds, $this->allowedEeGwsWebsiteIds);
        }
        return $wIds;
    }

    public function getTableColumnsDefaults(string $tableName): array
    {
        if ($tblColumns = $this->ddlTableColumns[$tableName] ?? false) {
            $tblColumns = array_keys($tblColumns);
            return array_combine(
                $tblColumns,
                array_map(
                    fn($col) => $this->tableColumnDefault($tableName, $col),
                    $tblColumns
                )
            );
        } else {
            throw new \RuntimeException(sprintf('Table "%s" information is missing.', $tableName));
        }
    }

    public function tableColumnDefault(string $tableName, string $columnName): int|string|null
    {
        if ($this->ddlTableColumns[$tableName] ?? false) {
            if ($this->ddlTableColumns[$tableName] ?? false) {
                $default = $this->ddlTableColumns[$tableName][$columnName]['DEFAULT'] ?? null;
                $nullable = $this->ddlTableColumns[$tableName][$columnName]['NULLABLE'] ?? true;
                return !$nullable ? $default : null;
            } else {
                throw new \RuntimeException(sprintf(
                    'Table "%s" column "%s" does not exist.',
                    $tableName, $columnName
                ));
            }
        } else {
            throw new \RuntimeException(sprintf('Table "%s" information is missing.', $tableName));
        }
    }

    public function productStaticFields(): array
    {
        return [
            'product.attribute_set' => 'attribute_set_id',
            'product.type' => 'type_id',
            'product.store' => 'store_id',
            'product.entity_id' => 'entity_id',
            'product.row_id' => 'row_id',
            'product.has_options' => 'has_options',
            'product.required_options' => 'required_options',
        ];
    }

    public function categoryStaticFields(): array
    {
        return [
            'category.attribute_set' => 'attribute_set_id',
            'category.parent_id' => 'parent_id',
            'category.path' => 'path',
            'category.entity_id' => 'entity_id',
            'category.position' => 'position',
            'category.level' => 'level',
            'category.row_id' => 'row_id',
            'category.children_count' => 'children_count',
        ];
    }

    public function now($dayOnly = false): false|string
    {
        return date($dayOnly ? 'Y-m-d' : 'Y-m-d H:i:s');
    }
}
