<?php


$this->startSetup();

if (version_compare(Mage::getVersion(), '1.3.0', '>='))
{
    /**
     * We can't rebuild the flat catalog here - we cant even register messages in
     * the session while we are in a setup script. So, this is a hack around this...
     *
     * @see DerModPro_BasePrice_Model_Observer::controllerActionLayoutLoadBefore()
     */
    Mage::register('baseprice_rebuild_flat_product_catalog', 1);
}

$this->endSetup();