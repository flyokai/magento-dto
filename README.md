# flyokai/magento-dto

> User docs → [`README.md`](README.md) · Agent quick-ref → [`CLAUDE.md`](CLAUDE.md) · Agent deep dive → [`AGENTS.md`](AGENTS.md)

> Magento-specific DTOs, container classes, and enums for catalog (products, categories), sales (orders, quotes), inventory, scope, and system configuration.

A vocabulary layer over `flyokai/data-mate`. Most entities are `GreyData`-based for flexible Magento payloads; identity (`HasId`, `HasAltId`) is set up consistently so generic flyokai code can index them.

## Features

- Cart / Quote / Address / AddressItem with Jar containers (SplObjectStorage parent/child)
- Category tree with name-path / URL-path indexes
- Product / Product\Attribute hierarchy with scoped data and global fallback
- Sales\Order with parent/child item relationships and quote item mappings
- Scope management (Store, Website, Container) with siblings lookups
- Comprehensive Magento enum set, including `TableName` (70+ table constants)
- Helpers: `ResolvedSkus`, `UrlKeys`, `CustomerGroup`, `EntityType`

## Installation

```bash
composer require flyokai/magento-dto
```

## Quick start

```php
use Flyokai\MagentoDto\Quote;
use Flyokai\MagentoDto\Sales\Order;
use Flyokai\MagentoDto\Definition\TableName;
use Flyokai\MagentoDto\Definition\Feature;

$quote = new Quote();
$quote->set('grand_total', 99.99);
$quote->set('increment_id', 'Q123');

$quote->id();              // null until persisted (or hashId fallback)
$quote->altId('increment_id');  // 'Q123'

$order = new Order();
$order->set('increment_id', 'O100000123');
TableName::CatalogProductEntity->value;   // 'catalog_product_entity'
```

## Catalog

### Category

| Class | Notes |
|-------|-------|
| `Category` | A node with `name_path` (array), URL paths, hierarchy level |
| `CategoryContainer` | Tree with indexes by `rowId`, `seqId`, `urlPath`, `namePath` |
| `Category\Attribute`, `Category\Attribute\Option`, `Category\Attribute\OptionContainer`, `Category\AttributeContainer` | Attribute model |
| `CategoryData`, `CategoryDataContainer` | Scoped attribute data — store-specific with global fallback |

### Product

| Class | Notes |
|-------|-------|
| `Product\Attribute`, `Product\Attribute\Option`, `Product\Attribute\OptionContainer`, `Product\AttributeContainer` | Attribute model |
| `Product\LinkType`, `Product\LinkTypeAttribute`, `Product\LinkTypeContainer` | Link types and their attributes |
| `ProductData`, `ProductDataContainer` | Scoped data with `getValue($field, $storeId)` falling back to `storeId=0` |

## Cart / Quote

| Class | Purpose |
|-------|---------|
| `Quote` | Main cart container; `altIdKeys: ['increment_id']` |
| `Quote\Item`, `Quote\Address`, `Quote\AddressItem`, `Quote\Product`, `Quote\DummyItem` | Cart elements |
| `CartItem` (interface) | `hashId()` |
| `ItemJar`, `AddressItemJar`, `AddressJar`, `ProductJar` | SplObjectStorage-based collections (parent/child relationships work with unsaved items) |
| `RateRequest`, `RateMethod`, `RateError`, `RateResult` | Shipping rates |

## Sales / Order

| Class | Notes |
|-------|-------|
| `Sales\Order` | Main order entity; `altIdKeys: ['increment_id']` |
| `Sales\Order\Item` | with weeeAmount/weeeTax |
| `Sales\Order\ItemJar` | Parent/child relationships + quote item mappings |
| `Sales\OrderHusk` | Flags for PO, shipment, dummy items; qty calculation methods |

## Scope

| Class | Notes |
|-------|-------|
| `ScopeStore` | `store_id`, `code`, `name`, `group_id`, `website_id`, `is_active`, `base_url` |
| `ScopeWebsite` | `website_id`, `code`, `name`, `default_group_id` |
| `ScopeContainer` | Manages stores/websites; provides siblings lookups |

## Configuration

| Class | Notes |
|-------|-------|
| `SystemConfig` | Central config: entities, customer groups, link types, scope, media attributes, features, DDL, translations, EE GWS filters |
| `StockConfig` | Stock settings via `ConfigJar` accessors |
| `Definition\Feature` | enum: `Msi`, `RowId`, `BundleSeq`, `SuperAttrRowId`, `BundleParent` |

```php
if ($systemConfig->hasFeature(Feature::Msi)) {
    // MSI-specific logic
}
```

## Enums (`Definition\` namespace)

`BackorderOption`, `EntityType`, `Feature`, `HandlingAction`, `HandlingType`, `ProductType`, `StockItemOptionName`, `StockOptionName`, `TableName` (70+ Magento table name constants).

## Helpers

- `ResolvedSkus` — SKU → rowId/entityId resolver (case-sensitive option)
- `UrlKeys` — URL key → rowId/entityId resolver
- `CustomerGroup`, `CustomerGroupContainer`
- `EntityType`, `EntityTypeContainer`

## Patterns

- GreyData classes override `id()` with type coercion: returns `null` for falsy values (0, '', null).
- Hash-ID fallback: database ID → reference ID → `spl_object_id()`.
- Scope resolution: `getValue($field, $storeId)` falls back to `storeId=0` (global).
- Feature flagging via `SystemConfig::hasFeature()`.
- SplObjectStorage for parent/child relationships — works correctly with unsaved items.

## Gotchas

- **Fragile items** — `fragile=true` skips ID validation. Code consuming such items must check `id() === null`.
- **`CategoryContainer` URL suffix** — both with-and-without suffix are indexed; lookups can be ambiguous.
- **`OptionContainer` case sensitivity** — configured per container; text is normalised in `initialize()`.
- **`TableName` enum** is intentionally large (70+ constants) — it's the canonical Magento table reference for the framework.

## See also

- [`flyokai/data-mate`](../data-mate/README.md) — DTO foundation
- [`flyokai/magento-amp-mate`](../magento-amp-mate/README.md) — async Magento cache backend

## License

MIT
