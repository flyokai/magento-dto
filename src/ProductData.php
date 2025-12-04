<?php

namespace Flyokai\MagentoDto;

/**
 * @phpstan-type TStoreId int
 * @phpstan-type TAttributeCode string
 * @phpstan-type TAttributeValue mixed
 * @phpstan-type TAttributeValueId int
 */
class ProductData
{
    /**
     * @var array<TStoreId, array<TAttributeCode, TAttributeValueId>>
     */
    private array $valueIds;

    /**
     * @var array<TStoreId, array<TAttributeCode, TAttributeValue>>
     */
    private array $data;

    /**
     * @param array<TStoreId, array<TAttributeCode, TAttributeValue>> $data
     */
    public function __construct(
        array $data,
        array $valueIds = [],
    )
    {
        $this->data = $data;
        $this->valueIds = $valueIds;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getValueIds(): array
    {
        return $this->valueIds;
    }

    public function addData(mixed $data, int $storeId=0, ?string $field=null): self
    {
        if ($field !== null) {
            $this->data[$storeId][$field] = $data;
        } else {
            $this->data[$storeId] = array_replace($this->data[$storeId]??[], $data);
        }
        return $this;
    }

    public function addValueIds(mixed $data, int $storeId=0, ?string $field=null): self
    {
        if ($field !== null) {
            $this->valueIds[$storeId][$field] = $data;
        } else {
            $this->valueIds[$storeId] = array_replace($this->valueIds[$storeId]??[], $data);
        }
        return $this;
    }

    public function getValue(string $field, int $storeId=0): mixed
    {
        return $this->data[$storeId][$field] ?? $this->data[0][$field] ?? null;
    }

    public function getValueId(string $field, int $storeId=0): mixed
    {
        return $this->valueIds[$storeId][$field] ?? $this->valueIds[0][$field] ?? null;
    }

    public function getStoreValue(string $field, int $storeId): mixed
    {
        return $this->data[$storeId][$field] ?? null;
    }

    public function getStoreValueId(string $field, int $storeId): mixed
    {
        return $this->valueIds[$storeId][$field] ?? null;
    }

}
