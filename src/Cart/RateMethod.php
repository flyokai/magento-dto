<?php

namespace Flyokai\MagentoDto\Cart;

use Flyokai\DataMate\GreyData;
use Flyokai\DataMate\Helper\GreyDataTrait;

class RateMethod implements GreyData, RateItem
{
    use GreyDataTrait {
        id as traitId;
    }

    public function __construct(
        private array $data,
    )
    {
    }

    private static string $type = 'MagentoCartRateError';
    private static string $idKey = 'entity_id';

    protected static ?array $altIdKeys = null;

    public static function altIdKeys(): array
    {
        return self::$altIdKeys ??= self::prepareAltIdKeys(
            []
        );
    }

}
