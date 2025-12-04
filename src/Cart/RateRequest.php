<?php

namespace Flyokai\MagentoDto\Cart;

use Flyokai\DataMate\GreyData;
use Flyokai\DataMate\Helper\GreyDataTrait;

class RateRequest implements GreyData
{
    use GreyDataTrait {
        id as traitId;
        addData as traitAddData;
    }

    public function __construct(
        private array                                      $data,
        public readonly QuoteHusk                          $quoteHusk,
        public readonly Quote\Address                      $address,
        public readonly Quote\ItemJar|Quote\AddressItemJar $itemJar,
        public readonly ?int                               $magentoReferenceId = null,
    )
    {
    }

    private static string $type = 'MagentoCartRateRequest';
    private static string $idKey = 'entity_id';

    protected static ?array $altIdKeys = null;

    public static function altIdKeys(): array
    {
        return self::$altIdKeys ??= self::prepareAltIdKeys(
            []
        );
    }

    public function id(): ?int
    {
        return $this->traitId() === null ? null : (int)$this->traitId();
    }

    public function addData(array $data): static
    {
        $data = array_filter(
            $data,
            fn($v, $k) => !in_array($k, ['all_items']),
            ARRAY_FILTER_USE_BOTH
        );
        return $this->traitAddData($data);
    }
}
