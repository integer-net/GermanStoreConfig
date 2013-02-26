<?php
/**
 * Der Modulprogrammierer - Vinai Kopp, Rico Neitzel GbR
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @copyright  Copyright (c) 2009 Der Modulprogrammierer - Vinai Kopp, Rico Neitzel GbR http://der-modulprogrammierer.de/
 * @copyright  Copyright (c) 2012 Netresearch GmbH 
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @var $this Mage_Eav_Model_Entity_Setup
 */
$this->startSetup();

$types = Mage::helper('baseprice')->isBasePriceProInstalledAndActive() ? 'simple,bundle,configurable' : 'simple';

$this->addAttribute('catalog_product', 'base_price_amount', array(
	'group'           => 'Prices',
	'type'            => 'varchar',
	'label'           => 'Amount in product',
	'input'           => 'text',
	//'source'          => 'baseprice/config_source_baseprice_product',
	'backend'         => 'baseprice/entity_backend_baseprice_amount',
	'frontend'        => 'baseprice/entity_frontend_baseprice_product_amount',
	'global'          => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
	'required'        => false,
	'default'         => '',
	'user_defined'    => 0,
	'apply_to'        => $types,
	'note'            => 'Leave empty to hide the display',
	//'is_configurable' => true
));

$this->addAttribute('catalog_product', 'base_price_unit', array(
	'group'           => 'Prices',
	'type'            => 'varchar',
	'label'           => 'Unit of product',
	'input'           => 'select',
	'source'          => 'baseprice/config_source_baseprice_unit',
	'backend'         => 'baseprice/entity_backend_baseprice_unit',
	'frontend'        => 'baseprice/entity_frontend_baseprice_product_unit',
	'global'          => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
	'required'        => false,
	'default'         => '',
	'user_defined'    => 0,
	'apply_to'        => $types,
	//'is_configurable' => true
));

$this->addAttribute('catalog_product', 'base_price_base_amount', array(
	'group'           => 'Prices',
	'type'            => 'varchar',
	'label'           => 'Reference amount',
	'input'           => 'text',
	//'source'          => 'baseprice/config_source_baseprice_unit',
	'backend'         => 'baseprice/entity_backend_baseprice_amount',
	'frontend'        => 'baseprice/entity_frontend_baseprice_reference_amount',
	'global'          => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
	'required'        => false,
	'default'         => '',
	'user_defined'    => 0,
	'apply_to'        => $types,
	//'is_configurable' => true
));

$this->addAttribute('catalog_product', 'base_price_base_unit', array(
	'group'           => 'Prices',
	'type'            => 'varchar',
	'label'           => 'Reference unit',
	'input'           => 'select',
	'source'          => 'baseprice/config_source_baseprice_unit',
	'backend'         => 'baseprice/entity_backend_baseprice_unit',
	'frontend'        => 'baseprice/entity_frontend_baseprice_reference_unit',
	'global'          => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
	'required'        => false,
	'default'         => '0',
	'user_defined'    => 0,
	'apply_to'        => $types,
	//'is_configurable' => true
));


/**
 * jup, a ugly hack - but setting the attribute_model per attribute isn't supported in Mage_Eav_Model_Entity_Setup::addAttribute()
 */
$this->run("
UPDATE {$this->getTable('eav_attribute')} SET `attribute_model`='baseprice/entity_resource_eav_attribute_product_amount' WHERE `attribute_code`='base_price_amount';
UPDATE {$this->getTable('eav_attribute')} SET `attribute_model`='baseprice/entity_resource_eav_attribute_product_unit' WHERE `attribute_code`='base_price_unit';
UPDATE {$this->getTable('eav_attribute')} SET `attribute_model`='baseprice/entity_resource_eav_attribute_reference_amount' WHERE `attribute_code`='base_price_base_amount';
UPDATE {$this->getTable('eav_attribute')} SET `attribute_model`='baseprice/entity_resource_eav_attribute_reference_unit' WHERE `attribute_code`='base_price_base_unit';
");

$this->endSetup();


// EOF