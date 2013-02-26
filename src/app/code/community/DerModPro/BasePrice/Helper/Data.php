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
 * Helper for the baseprice extension.
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @author     Vinai Kopp <vinai@der-modulprogrammierer.de>
 */
class DerModPro_BasePrice_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Return the baseprice lable for the given product. If no baseprice is set return ''
	 * Possible template "variables":
	 *  {{baseprice}}			=> the baseprice value
	 *  {{product_amount}}		=> the product amount
	 *  {{product_unit}}		=> the product unit, full format
	 *  {{product_unit_short}}	=> the product unit, short format
	 *  {{reference_amount}}	=> the reference amount
	 *  {{reference_unit}}		=> the reference unit, full format
	 *  {{reference_unit_short}}=> the reference unit, short format
	 *
	 * @param Mage_Catalog_Model_Product $product
	 * @param boolean|string $labelFormat FALSE = configured long lable, TRUE = configured short lable, "STRING" = the string is used as a format template
	 * @return string
	 */
	public function getBasePriceLabel($product, $labelFormat = false)
	{
		if (! ($productAmount = $product->getBasePriceAmount())) return '';

		$this->_loadDefaultBasePriceValues($product);

		if (! ($referenceAmount = $product->getBasePriceBaseAmount())) return '';
		if (! ($productPrice = $product->getFinalPrice())) return '';
		if (! is_numeric($productAmount) || ! is_numeric($referenceAmount) || ! is_numeric($productPrice)) return '';
		
		$productUnit = $product->getBasePriceUnit();
		$referenceUnit = $product->getBasePriceBaseUnit();
		
		$productPrice = Mage::helper('tax')->getPrice($product, $productPrice, $this->getConfig('base_price_incl_tax'));
		$basePriceModel = Mage::getModel('baseprice/baseprice', array('reference_unit' => $referenceUnit, 'reference_amount' => $referenceAmount));
		$basePrice = $basePriceModel->getBasePrice($productAmount, $productUnit, $productPrice);

		if (is_string($labelFormat))
		{
			$label = $labelFormat;
		}
		else
		{
			$configKey = $labelFormat ? 'short_label' : 'frontend_label';
			$label = $this->__($this->getConfig($configKey));
		}
		$label = str_replace('{{baseprice}}', Mage::helper('core')->currency($basePrice), $label);
		$label = str_replace('{{product_amount}}', $productAmount, $label);
		$label = str_replace('{{product_unit}}', $this->__(DerModPro_BasePrice_Model_Baseprice::UNIT_TRANSLATION_PREFIX.$productUnit), $label);
		$label = str_replace('{{product_unit_short}}', $this->__(DerModPro_BasePrice_Model_Baseprice::UNIT_TRANSLATION_PREFIX_SHORT.$productUnit), $label);
		$label = str_replace('{{reference_amount}}', $referenceAmount, $label);
		$label = str_replace('{{reference_unit}}', $this->__(DerModPro_BasePrice_Model_Baseprice::UNIT_TRANSLATION_PREFIX.$referenceUnit), $label);
		$label = str_replace('{{reference_unit_short}}', $this->__(DerModPro_BasePrice_Model_Baseprice::UNIT_TRANSLATION_PREFIX_SHORT.$referenceUnit), $label);
		return $label;
	}

	/**
	 * Set the configuration default values on the product model.
	 * Used when products allready existed when the extension was installed.
	 *
	 * @param Mage_Catalog_Model_Product $product
	 * @return DerModPro_BasePrice_Helper_Data
	 */
	protected function _loadDefaultBasePriceValues($product)
	{
		foreach (array('base_price_base_amount', 'base_price_unit', 'base_price_base_unit') as $attributeCode)
		{
			if (! $product->getDataUsingMethod($attributeCode))
			{
				$attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', $attributeCode);
				$product->setDataUsingMethod($attributeCode, $attribute->getFrontend()->getValue($product));
			}
		}
		return $this;
	}
	
	/**
	 * Check if the script is called from the adminhtml interface
	 *
	 * @return boolean
	 */
	public function inAdmin()
	{
		return Mage::app()->getStore()->isAdmin();
	}
	
	/**
	 * Dump a variable to the logfile (defaults to hideprices.log)
	 *
	 * @param mixed $var
	 * @param string $file
	 */
	public function log($var, $file = null)
	{
		$file = isset($file) ? $file : 'baseprice.log';
		
		$var = print_r($var, 1);
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $var = str_replace("\n", "\r\n", $var);
		Mage::log($var, null, $file);
	}

	/**
	 * Check if the extension has been disabled in the system configuration
	 * 
	 * @return boolean
	 */
	public function moduleActive()
	{
		return ! (bool) $this->getConfig('disable_ext');
	}
	
	/**
	 * Return the config value for the passed key (current store)
	 * 
	 * @param string $key
	 * @return string
	 */
	public function getConfig($key)
	{
		$path = 'catalog/baseprice/' . $key;
		return Mage::getStoreConfig($path, Mage::app()->getStore());
	}
	
	/**
	 * Check if the BasePricePro extension is installed and active
	 *
	 * @return boolean
	 */
    public function isBasePriceProInstalledAndActive()
    {
    	if ($node = Mage::getConfig()->getNode('modules/DerModPro_BasePricePro'))
    	{
    		return strval($node->active) == 'true';
    	}
    	return false;
    }
}

