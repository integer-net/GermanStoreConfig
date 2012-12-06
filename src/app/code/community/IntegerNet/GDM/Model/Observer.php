<?php
class IntegerNet_GDM_Model_Observer
{
    /**
     * Set theme to "gdm" with fallback to "default"
     *
     * @param Varien_Event_Observer $observer
     */
    public function predispatchInstallWizard($observer)
    {
        Mage::getDesign()->setTheme('gdm');
    }

    /**
     * Set default Timezone and Currency
     *
     * @param Varien_Event_Observer $observer
     */
    public function predispatchInstallStart($observer)
    {
        Mage::getSingleton('install/session')->setTimezone('Europe/Berlin');
        Mage::getSingleton('install/session')->setCurrency('EUR');
    }
}