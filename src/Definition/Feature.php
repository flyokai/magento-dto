<?php

namespace Flyokai\MagentoDto\Definition;

enum Feature: string
{
    case Msi = 'msi';
    case RowId = 'row_id';
    case BundleSeq = 'bundle_seq';
    case SuperAttrRowId = 'super_attr_row_id';
    case BundleParent = 'bundle_parent';
}
