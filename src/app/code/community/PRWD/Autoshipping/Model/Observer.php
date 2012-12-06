<?php

/**
 * PRWD Auto Shipping Module
 *
 * NOTICE OF LICENSE
 *
  Copyright (C) 2009 PRWD (http://www.prwd.co.uk)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

class PRWD_Autoshipping_Model_Observer
{
	public function __construct()
	{
		
	}
	/**
	* 
	* @param   Varien_Event_Observer $observer
	*/
	public function add_shipping($observer)
	{
		if (Mage::getStoreConfig('autoshipping/settings/enabled'))
		{
			$country = Mage::getStoreConfig('autoshipping/settings/country_id');
			Mage::getSingleton('core/session')->setAutoShippingCountry($country);

			Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()
				->setCountryId($country)
				->setCollectShippingRates(true);
			
			Mage::getSingleton('checkout/session')->getQuote()
				->getShippingAddress()->collectShippingRates();
				
			$rates = Mage::getSingleton('checkout/session')->getQuote()
				->getShippingAddress()->getGroupedAllShippingRates();
			
			if (count($rates)) {
				$topRate = reset($rates);
				$code = $topRate[0]->code;
				
				try {
					Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()
						->setShippingMethod($code);
						
					Mage::getSingleton('checkout/session')->getQuote()->save();
					
					Mage::getSingleton('checkout/session')->resetCheckout();
					
				}
				catch (Mage_Core_Exception $e) {
					Mage::getSingleton('checkout/session')->addError($e->getMessage());
				}
				catch (Exception $e) {
					Mage::getSingleton('checkout/session')->addException(
						$e, Mage::helper('checkout')->__('Load customer quote error')
					);
				}
				
			}

			return $this;
		}
	}
	
	public function check_country($observer)
	{
		if (Mage::getStoreConfig('autoshipping/settings/enabled'))
		{
			$country = Mage::getStoreConfig('autoshipping/settings/country_id');
			$sessCountry = Mage::getSingleton('core/session')->getAutoShippingCountry();
			
			if ($country != $sessCountry) {
				$this->add_shipping($observer);
			}
		}
	}
}
?>
