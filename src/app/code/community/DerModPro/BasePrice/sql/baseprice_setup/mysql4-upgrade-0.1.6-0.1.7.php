<?php

$this->startSetup();

$this->updateAttribute('catalog_product', 'base_price_unit', 'is_filterable_in_search', '0');
$this->updateAttribute('catalog_product', 'base_price_base_unit', 'is_filterable_in_search', '0');

$this->endSetup();