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
 * Observer for the baseprice extension.
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @author     Vinai Kopp <vinai@der-modulprogrammierer.de>
 */
class DerModPro_BasePrice_Model_Observer extends Mage_Core_Model_Abstract
{
    /**
     * Since I can't register session messages in upgrade scripts...
     * this little hack might do it
     *
	 * @param Varien_Event_Observer $observer
     */
    public function controllerActionLayoutLoadBefore($observer)
    {
        if (Mage::registry('baseprice_rebuild_flat_product_catalog'))
        {
            try
            {
                Mage::getResourceModel('catalog/product_flat_indexer')->rebuild();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('baseprice')->__('Flat Catalog Product was rebuilt successfully after baseprice installation'));
            }
            catch (Mage_Core_Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('baseprice')->__('Error rebuilding flat product catalog:') . ' ' . $e->getMessage());
            }
        }
    }

	/**
	 * Append the baseprice html if necessary (frontend)
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function blockCatalogProductGetPriceHtml($observer)
	{
		if (
			! Mage::helper('baseprice')->moduleActive() ||
			Mage::helper('baseprice')->inAdmin() ||
			! Mage::helper('baseprice')->getConfig('auto_append_base_price')
		) return;
		$block = $observer->getBlock();
		$container = $observer->getContainer();
		$block->setTemplate('baseprice/baseprice.phtml');
		$html = $container->getHtml() . $block->toHtml();
		$container->setHtml($html);
	}

	/**
	 * Set the default value on a product in the admin interface
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function catalogProductLoadAfter($observer)
	{
		//Mage::helper('baseprice')->log(__CLASS__ . '::' . __FUNCTION__ . '() called');
		if (! Mage::helper('baseprice')->moduleActive()) return;
		$product = $observer->getProduct();
		foreach (array('base_price_amount', 'base_price_unit', 'base_price_base_amount', 'base_price_base_unit') as $attributeCode)
		{
			//Mage::helper('baseprice')->log('loading ' . $attributeCode . ' default');
			$data = $product->getDataUsingMethod($attributeCode);
			if (! isset($data))
			{
				//Mage::helper('baseprice')->log('setting  ' . $attributeCode . ' default');
				$attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', $attributeCode);
				$product->setDataUsingMethod($attributeCode, $attribute->getFrontend()->getValue($product));
			}
		}
	}

	/**
	 * Check the unit types selected in the admin interface are compatible
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function catalogProductSaveBefore($observer)
	{
		if (! Mage::helper('baseprice')->moduleActive()) return;
		$product = $observer->getProduct();
		if ($product->getBasePriceAmount())
		{
			$fromUnit = $product->getBasePriceUnit();
			$toUnit = $product->getBasePriceBaseUnit();
			// will throw Exception if no conversion rate is defined
			try {
				$rate = Mage::getSingleton('baseprice/baseprice')->getConversionRate($fromUnit, $toUnit);
			}
			catch (Exception $e)
			{
				Mage::throwException($e->getMessage() . "<br/>\n" . Mage::helper('baseprice')->__('The product settings where not saved'));
			}
		}
	}

	/**
	 * Set the default values if BCP is installed and price updates are configured.
	 * If BCP is not installed this event will never be fired.
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function bcpUpdateDefaultsOnConfigurableProduct($observer)
	{
		$product = $observer->getEvent()->getProduct();
		$simpleProduct = $observer->getEvent()->getSimpleProduct();

		foreach (array('base_price_amount', 'base_price_unit', 'base_price_base_amount', 'base_price_base_unit') as $attributeCode)
		{
			$value = $simpleProduct->getDataUsingMethod($attributeCode);
			$product->setDataUsingMethod($attributeCode, $value);
		}
	}
}

