<?php

namespace Flyokai\MagentoDto\Cart\Quote;

use Flyokai\DataMate\GreyData;
use Flyokai\DataMate\Helper\GreyDataTrait;

class Product implements GreyData
{
    use GreyDataTrait {
        id as traitId;
    }

    protected static ?array $altIdKeys = null;
    private static string $type = 'MagentoCartProduct';
    private static string $idKey = 'entity_id';

    public function __construct(
        private array        $data,
        public readonly ?int $magentoReferenceId = null,
    )
    {
    }

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
