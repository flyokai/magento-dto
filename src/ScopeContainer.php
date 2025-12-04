<?php

namespace Flyokai\MagentoDto;

use Flyokai\DataMate\Helper\DtoTrait;

class ScopeContainer
{
    use DtoTrait;

    private array $websiteStores = [];
    private array $storeById = [];
    private array $storeByCode = [];
    private array $websiteById = [];
    private array $websiteByCode = [];

    /**
     * @param ScopeStore[] $stores
     * @param ScopeWebsite[] $websites
     */
    public function __construct(
        public readonly array $stores,
        public readonly array $websites,
    )
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        foreach ($this->stores as $store) {
            $sId = $store->store_id;
            $wId = $store->website_id;
            $this->storeById[$sId] = $store;
            $this->storeByCode[$store->code] = $store;
            foreach ($this->websites as $website) {
                $this->websiteById[$website->website_id] = $website;
                $this->websiteByCode[$website->code] = $website;
                if ($website->website_id == $wId) {
                    $this->websiteStores[$wId][$sId] = $store;
                    break;
                }
            }
        }
    }

    public function __wakeup(): void
    {
        $this->initialize();
    }

    public function storeById(?int $id=null): ScopeStore|array|null
    {
        return $id !== null
            ? ($this->storeById[$id] ?? null)
            : $this->storeById;
    }

    public function storeByCode(?string $code=null): ScopeStore|array|null
    {
        return $code !== null
            ? ($this->storeByCode[$code] ?? null)
            : $this->storeByCode;
    }

    public function websiteById(?int $id=null): ScopeWebsite|array|null
    {
        return $id !== null
            ? ($this->storeById[$id] ?? null)
            : $this->storeById;
    }

    public function websiteByCode(?string $code=null): ScopeWebsite|array|null
    {
        return $code !== null
            ? ($this->websiteByCode[$code] ?? null)
            : $this->websiteByCode;
    }

    public function storeSiblings(int $id, bool $returnIds): array
    {
        $store = $this->storeById($id);
        if (!$store) return [];
        $wsId = $store->website_id;
        return !$returnIds
            ? ($this->websiteStores[$wsId] ?? [])
            : array_keys($this->websiteStores[$wsId] ?? []);
    }
}
