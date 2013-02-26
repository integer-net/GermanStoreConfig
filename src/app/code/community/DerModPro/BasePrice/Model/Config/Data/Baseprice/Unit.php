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
 * Config data backend model for unit selection
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @author     Vinai Kopp <vinai@der-modulprogrammierer.de>
 */
class DerModPro_BasePrice_Model_Config_Data_Baseprice_Unit
	extends Mage_Core_Model_Config_Data
{
	
	/**
	 * Prepare the unit selecton array before saving
	 *
	 * @param Mage_Catalog_Model_Product $object
	 * @return nothing afaik :)
	 */
    public function _beforeSave()
    {
        $data = $data = $this->getValue();
        $default = Mage::helper('baseprice')->getConfig('default_base_price_base_unit');
        
        /**
         * Default to using the default - don't let the user select nothing
         */
        if (empty($data)) {
        	$data = $this->setValue(array($default));
        }
        return parent::_beforeSave();
    }
    
	public function getDefaultValue()
	{
		return Mage::helper('baseprice')->getConfig('default_base_price_base_unit');
	}
}
