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

class PRWD_Autoshipping_Helper_Data extends Mage_Core_Helper_Abstract
{

  const XML_PATH_ENABLED     = 'autoshipping/settings/enabled';
  const XML_PATH_COUNTRY     = 'autoquote/settings/country_id';


	
	public function isEnabled()
    {
        return Mage::getStoreConfig( self::XML_PATH_ENABLED );
    }

    public function isCountry_id()
    {
        return Mage::getStoreConfig( self::XML_PATH_COUNTRY );
    }


}

