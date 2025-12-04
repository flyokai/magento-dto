<?php

namespace Flyokai\MagentoDto\Cart\Quote;

use Flyokai\DataMate\GreyData;
use Flyokai\DataMate\Helper\GreyDataTrait;

class Address implements GreyData
{
    use GreyDataTrait {
        id as traitId;
    }

    protected static ?array $altIdKeys = null;
    private static string $type = 'MagentoCartQuoteAddress';
    private static string $idKey = 'address_id';

    public function __construct(
        private array                          $data,
        public readonly AddressItemJar|ItemJar $itemJar,
        public readonly ?int                   $magentoReferenceId = null,
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        $this->hashId = $this->id() ?? $this->magentoReferenceId ?? spl_object_id($this);
    }

    public function __wakeup(): void
    {
        $this->initialize();
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
        return $this->traitId() === null ? null : (int)$this->traitId();
    }
}
