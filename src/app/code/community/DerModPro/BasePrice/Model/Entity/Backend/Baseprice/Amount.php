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
 * Backend model for baseprice amount attribute
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @author     Vinai Kopp <vinai@der-modulprogrammierer.de>
 */
class DerModPro_BasePrice_Model_Entity_Backend_Baseprice_Amount
	extends Mage_Eav_Model_Entity_Attribute_Backend_Default
	       
{
	public function validate($object)
	{
		if (parent::validate($object))
		{
			$attrCode = $this->getAttribute()->getAttributeCode();
			$data = $object->getData($attrCode);
			if ($data)
			{
				if (! is_numeric($data))
				{
					Mage::throwException(Mage::helper('baseprice')->__('The Baseprice amount must be a numeric value'));
				}
				if ($data < 0)
				{
					Mage::throwException(Mage::helper('baseprice')->__('The Baseprice amount must greater then zero'));
				}
			}
		}
		return true;
	}
}
