<?php

namespace Flyokai\MagentoDto\Cart\Quote;

use Flyokai\DataMate\Helper\GreyDataTrait;
use Flyokai\MagentoDto\Cart\CartItem;

class DummyItem implements CartItem
{
    use GreyDataTrait {
        id as traitId;
    }

    protected static ?array $altIdKeys = null;
    private static string $type = 'MagentoCartQuoteDummyItem';
    private static string $idKey = 'item_id';

    private int $hashId;

    public function __construct(
        private array $data,
    )
    {
        $this->hashId = $this->id() ?? spl_object_id($this);
    }

    public static function altIdKeys(): array
    {
        return self::$altIdKeys ??= self::prepareAltIdKeys(
            []
        );
    }

    public function hashId(): int
    {
        return $this->hashId;
    }

    public function id(): ?int
    {
        return in_array($this->traitId(), [null, '', 0]) ? null : (int)$this->traitId();
    }
}
