# flyokai/magento-dto

> User docs → [`README.md`](README.md) · Agent quick-ref → [`CLAUDE.md`](CLAUDE.md) · Agent deep dive → [`AGENTS.md`](AGENTS.md)

Magento-specific DTOs for catalog (products, categories), sales (orders, quotes), inventory, and system configuration.

See [AGENTS.md](AGENTS.md) for detailed module knowledge.

## Quick Reference

- **Cart**: Quote, Quote\Item, Quote\Address + Jar containers (SplObjectStorage parent/child)
- **Catalog**: Category/CategoryContainer, Product\Attribute/AttributeContainer, scoped data with global fallback
- **Sales**: Order, Order\Item, OrderHusk (qty calculations)
- **Scope**: ScopeStore, ScopeWebsite, ScopeContainer
- **Config**: SystemConfig (central), StockConfig, Feature enum
- **Enums**: ProductType, EntityType, BackorderOption, TableName (70+ tables)
- **Helpers**: ResolvedSkus, UrlKeys, CustomerGroup
