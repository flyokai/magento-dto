<?php

namespace Flyokai\MagentoDto\Cart;

use Flyokai\DataMate\GreyData;
use Flyokai\DataMate\Helper\GreyDataTrait;

class Quote implements GreyData
{
    use GreyDataTrait {
        id as traitId;
    }

    public function __construct(
        private array                    $data,
        public readonly Quote\AddressJar $addressJar,
        public readonly Quote\ItemJar    $itemJar,
        public readonly Quote\ProductJar $productJar,
        public readonly int              $storeId,
        public readonly int              $websiteId,
        public readonly ?int             $magentoReferenceId = null,
    )
    {
    }

    private static string $type = 'MagentoCartQuote';
    private static string $idKey = 'entity_id';

    protected static ?array $altIdKeys = null;

    public static function altIdKeys(): array
    {
        return self::$altIdKeys ??= self::prepareAltIdKeys(
            [self::incrementAltIdKey()]
        );
    }

    public static function incrementAltIdKey(): string
    {
        return 'increment_id';
    }

    public function id(): ?int
    {
        return $this->traitId() === null ? null : (int)$this->traitId();
    }
}
