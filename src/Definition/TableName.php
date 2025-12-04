<?php

namespace Flyokai\MagentoDto\Definition;

enum TableName: string implements \Flyokai\ServiceData\TableName
{
    case CatalogCategoryEntity = 'catalog_category_entity';
    case CatalogCategoryProduct = 'catalog_category_product';
    case CatalogEavAttribute = 'catalog_eav_attribute';
    case CatalogProductBundleOption = 'catalog_product_bundle_option';
    case CatalogProductBundleOptionSeq = 'sequence_product_bundle_option';
    case CatalogProductBundleOptionValue = 'catalog_product_bundle_option_value';
    case CatalogProductBundleSelection = 'catalog_product_bundle_selection';
    case CatalogProductBundleSelectionSeq = 'sequence_product_bundle_selection';
    case CatalogProductBundleSelectionPrice = 'catalog_product_bundle_selection_price';
    case CatalogProductEntity = 'catalog_product_entity';
    case CatalogProductEntityGroupPrice = 'catalog_product_entity_group_price';
    case CatalogProductEntityMediaGallery = 'catalog_product_entity_media_gallery';
    case CatalogProductEntityMediaGalleryValue = 'catalog_product_entity_media_gallery_value';
    case CatalogProductEntityMediaGalleryValueEntity = 'catalog_product_entity_media_gallery_value_to_entity';
    case CatalogProductEntityMediaGalleryValueVideo = 'catalog_product_entity_media_gallery_value_video';
    case CatalogProductEntityTierPrice = 'catalog_product_entity_tier_price';
    case CatalogProductEntityVarchar = 'catalog_product_entity_varchar';
    case CatalogProductLink = 'catalog_product_link';
    case CatalogProductLinkAttribute = 'catalog_product_link_attribute';
    case CatalogProductLinkType = 'catalog_product_link_type';
    case CatalogProductOption = 'catalog_product_option';
    case CatalogProductOptionPrice = 'catalog_product_option_price';
    case CatalogProductOptionTitle = 'catalog_product_option_title';
    case CatalogProductOptionTypePrice = 'catalog_product_option_type_price';
    case CatalogProductOptionTypeTitle = 'catalog_product_option_type_title';
    case CatalogProductOptionTypeValue = 'catalog_product_option_type_value';
    case CatalogProductRelation = 'catalog_product_relation';
    case CatalogProductSuperAttribute = 'catalog_product_super_attribute';
    case CatalogProductSuperAttributeLabel = 'catalog_product_super_attribute_label';
    case CatalogProductSuperAttributePricing = 'catalog_product_super_attribute_pricing';
    case CatalogProductSuperLink = 'catalog_product_super_link';
    case CatalogProductWebsite = 'catalog_product_website';
    case CatalogInventoryStockItem = 'cataloginventory_stock_item';
    case CatalogInventoryStockStatus = 'cataloginventory_stock_status';
    case GiftcardAccount = 'magento_giftcardaccount';
    case GiftcardAccountHistory = 'magento_giftcardaccount_history';
    case InventorySource = 'inventory_source';
    case InventoryStock = 'inventory_stock';
    case InventorySourceItem = 'inventory_source_item';
    case InventorySourceStockLink = 'inventory_source_stock_link';
    case InventoryStockSalesChannel = 'inventory_stock_sales_channel';
    case CategorySequence = 'sequence_catalog_category';
    case CustomerEntity = 'customer_entity';
    case CustomerGroup = 'customer_group';
    case DownloadableLink = 'downloadable_link';
    case DownloadableLinkPrice = 'downloadable_link_price';
    case DownloadableLinkTitle = 'downloadable_link_title';
    case DownloadableSample = 'downloadable_sample';
    case DownloadableSampleTitle = 'downloadable_sample_title';
    case EavAttribute = 'eav_attribute';
    case EavAttributeGroup = 'eav_attribute_group';
    case EavAttributeLabel = 'eav_attribute_label';
    case EavAttributeOption = 'eav_attribute_option';
    case EavAttributeOptionSwatch = 'eav_attribute_option_swatch';
    case EavAttributeOptionValue = 'eav_attribute_option_value';
    case EavAttributeSet = 'eav_attribute_set';
    case EavEntityAttribute = 'eav_entity_attribute';
    case EavEntityType = 'eav_entity_type';
    case ProductSequence = 'sequence_product';
    case Store = 'store';
    case StoreGroup = 'store_group';
    case StoreWebsite = 'store_website';
    case UrlkeyIndex = 'urapidflow_urlkey_index';
    case RapidflowProfile = 'urapidflow_profile';
    case UdropshipVendorProduct = 'udropship_vendor_product';
    case UdmultiTierPrice = 'udmulti_tier_price';

    public function value(): string
    {
        return $this->value;
    }

}
