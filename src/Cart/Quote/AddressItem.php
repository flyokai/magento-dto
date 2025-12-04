<?php

namespace Flyokai\MagentoDto\Cart\Quote;

use Flyokai\DataMate\Helper\GreyDataTrait;
use Flyokai\MagentoDto\Cart\CartItem;

class AddressItem implements CartItem
{
    use GreyDataTrait {
        id as traitId;
    }

    protected static ?array $altIdKeys = null;
    private static string $type = 'MagentoCartQuoteAddressItem';
    private static string $idKey = 'address_item_id';

    public function __construct(
        private array        $data,
        public readonly ?int $magentoReferenceId = null,
    )
    {
        $this->hashId = $this->id() ?? $this->magentoReferenceId ?? spl_object_id($this);
    }

    public static function altIdKeys(): array
    {
        return self::$altIdKeys ??= self::prepareAltIdKeys(
            []
        );
    }

    private int $hashId;

    public function hashId(): int
    {
        return $this->hashId;
    }

    public function id(): ?int
    {
        return in_array($this->traitId(), [null, '', 0]) ? null : (int)$this->traitId();
    }
}
