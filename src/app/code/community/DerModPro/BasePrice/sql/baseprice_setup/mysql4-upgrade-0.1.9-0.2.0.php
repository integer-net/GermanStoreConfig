<?php

$this->startSetup();

$this->updateAttribute('catalog_product', 'base_price_unit', 'source_model', 'baseprice/entity_source_baseprice_product_unit');
$this->updateAttribute('catalog_product', 'base_price_base_unit', 'source_model', 'baseprice/entity_source_baseprice_reference_unit');

if (version_compare(Mage::getVersion(), '1.3.0', '>='))
{
    /**
     * We can't rebuild the flat catalog here - we cant even register messages in
     * the session while we are in a setup script. So, this is a hack around this...
	 * Also, if this is an upgrade from 0.1.8 of earlier, the rebuild flat alread
	 * is registered.
     *
     * @see DerModPro_BasePrice_Model_Observer::controllerActionLayoutLoadBefore()
     */
	if (! Mage::registry('baseprice_rebuild_flat_product_catalog'))
	{
		Mage::register('baseprice_rebuild_flat_product_catalog', 1);
	}
}

$this->endSetup();