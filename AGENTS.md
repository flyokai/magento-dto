# flyokai/magento-dto

> User docs → [`README.md`](README.md) · Agent quick-ref → [`CLAUDE.md`](CLAUDE.md) · Agent deep dive → [`AGENTS.md`](AGENTS.md)

Magento-specific DTOs, enums, and container classes for catalog, sales, and inventory data.

## Key Abstractions

### Cart/Quote (GreyData-based)
- `Quote` — main cart container, altIdKeys: ['increment_id']
- `Quote\Item`, `Quote\Address`, `Quote\AddressItem`, `Quote\Product`, `Quote\DummyItem`
- `CartItem` interface with `hashId()` method
- Jar containers: `ItemJar` (SplObjectStorage for parent/child), `AddressItemJar`, `AddressJar`, `ProductJar`
- `RateRequest`, `RateMethod`, `RateError`, `RateResult` — shipping rate system

### Category
- `Category` — node with `name_path` (array), URL paths, hierarchy level
- `CategoryContainer` — tree with indexes: rowId, seqId, urlPath, namePath
- `Category\Attribute`, `Category\Attribute\Option`, `Category\Attribute\OptionContainer`, `Category\AttributeContainer`
- `CategoryData` / `CategoryDataContainer` — scoped attribute data (store-specific with global fallback)

### Product
- `Product\Attribute`, `Product\Attribute\Option`, `Product\Attribute\OptionContainer`, `Product\AttributeContainer`
- `Product\LinkType`, `Product\LinkTypeAttribute`, `Product\LinkTypeContainer`
- `ProductData` / `ProductDataContainer` — scoped data with `getValue(field, storeId)` falling back to storeId=0

### Sales/Order (GreyData-based)
- `Sales\Order` — main order entity, altIdKeys: ['increment_id']
- `Sales\Order\Item` — with weeeAmount/weeeTax
- `Sales\Order\ItemJar` — parent/child relationships + quote item mappings
- `Sales\OrderHusk` — flags for PO, shipment, dummy items; qty calculation methods

### Scope Management
- `ScopeStore` — store_id, code, name, group_id, website_id, is_active, base_url
- `ScopeWebsite` — website_id, code, name, default_group_id
- `ScopeContainer` — manages stores/websites, provides siblings lookups

### Configuration
- `SystemConfig` — central config: entities, customer groups, link types, scope, media attributes, features, DDL, translations, EE GWS filters
- `StockConfig` — stock settings via ConfigJar accessors
- `Feature` enum: Msi, RowId, BundleSeq, SuperAttrRowId, BundleParent

### Enums (Definition namespace)
- `BackorderOption`, `EntityType`, `Feature`, `HandlingAction`, `HandlingType`, `ProductType`
- `StockItemOptionName`, `StockOptionName`
- `TableName` — 70+ Magento table name constants

### Helpers
- `ResolvedSkus` — SKU → rowId/entityId resolver (case-sensitive option)
- `UrlKeys` — URL key → rowId/entityId resolver
- `CustomerGroup` / `CustomerGroupContainer`
- `EntityType` / `EntityTypeContainer`

## Patterns

- GreyData classes override `id()` with type coercion: returns null for falsy values (0, '', null)
- Hash ID fallback: database ID → reference ID → spl_object_id
- Scope resolution: `getValue(field, storeId)` falls back to storeId=0 (global)
- Feature flagging: `SystemConfig::hasFeature(Feature)` for conditional behavior
- SplObjectStorage for parent/child relationships (works with unsaved items)

## Gotchas

- **Fragile items**: `fragile=true` skips ID validation — code must check `id() === null`
- **CategoryContainer URL suffix**: both with/without suffix indexed, can cause ambiguity
- **OptionContainer case sensitivity**: configured per container, text normalized in `initialize()`
- **TableName enum**: 70+ constants — comprehensive Magento table reference
