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
 * Product View block
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @author     Vinai Kopp <vinai@der-modulprogrammierer.de>
 */
class DerModPro_BasePrice_Block_Catalog_Product_View extends Mage_Catalog_Block_Product_View
{
	/**
	 * Set the module translaton namespace
	 */
	public function _construct()
	{
		$this->setData('module_name', 'Mage_Catalog');
	}
	
	/**
     * Returns product price block html
     *
     * @param Mage_Catalog_Model_Product $product
     * @param boolean $displayMinimalPrice
     */
    public function getPriceHtml($product, $displayMinimalPrice = false, $idSuffix='')
    {
    	$html = parent::getPriceHtml($product, $displayMinimalPrice, $idSuffix);
		$container = new Varien_Object();
		$container->setHtml($html);
		Mage::dispatchEvent('block_catalog_product_get_price_html', array('block' => $this, 'container' => $container));
		$html = $container->getHtml();
		return $html;
    }
}
