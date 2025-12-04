<?php

namespace Flyokai\MagentoDto\Sales\Order;

use Flyokai\DataMate\GreyData;
use Flyokai\DataMate\Helper\GreyDataTrait;

class Item implements GreyData
{
    use GreyDataTrait {
        id as traitId;
    }

    public function __construct(
        private array $data,
        public readonly float $weeeAmount,
        public readonly float $weeeTax,
        public readonly ?int $magentoReferenceId = null,
    )
    {
    }

    private static string $type = 'MagentoSalesOrderItem';
    private static string $idKey = 'item_id';

    protected static ?array $altIdKeys=null;
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
}
