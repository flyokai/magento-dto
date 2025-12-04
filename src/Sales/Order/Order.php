<?php

namespace Flyokai\MagentoDto\Sales;

use Flyokai\DataMate\GreyData;
use Flyokai\DataMate\Helper\GreyDataTrait;
use Flyokai\MagentoDto\Sales\Order\ItemJar;

class Order implements GreyData
{
    use GreyDataTrait {
        id as traitId;
    }

    public function __construct(
        private array $data,
        public readonly ItemJar $itemJar,
        public readonly ?int $magentoReferenceId = null,
    )
    {
    }

    private static string $type = 'MagentoSalesOrder';
    private static string $idKey = 'entity_id';

    protected static ?array $altIdKeys=null;
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
