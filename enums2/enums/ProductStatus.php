<?php
// File: enums/ProductStatus.php
namespace Enums;

enum ProductStatus: string {
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DISCONTINUED = 'discontinued';
}
