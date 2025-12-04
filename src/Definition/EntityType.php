<?php

namespace Flyokai\MagentoDto\Definition;

enum EntityType: string
{
    case Product = 'catalog_product';
    case Category = 'catalog_category';
    case Customer = 'customer';
    case CustomerAddress = 'customer_address';
    case Order = 'order';
    case Invoice = 'invoice';
    case Creditmemo = 'creditmemo';
    case Shipment = 'shipment';
    case Quote = 'quote';
}
