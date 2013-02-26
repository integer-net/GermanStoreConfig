<?php

$this->startSetup();

$this->updateAttribute('catalog_product', 'base_price_unit', 'used_in_product_listing', '1');
$this->updateAttribute('catalog_product', 'base_price_base_unit', 'used_in_product_listing', '1');
$this->updateAttribute('catalog_product', 'base_price_amount', 'used_in_product_listing', '1');
$this->updateAttribute('catalog_product', 'base_price_base_amount', 'used_in_product_listing', '1');

$this->endSetup();