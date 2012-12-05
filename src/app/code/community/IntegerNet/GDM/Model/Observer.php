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

    /**
     * Redirect to GDM form on first admin login
     *
     * @param Varien_Event_Observer $observer
     */
    public function afterAdminUserLogin($observer)
    {
        // run only once
        if (Mage::getStoreConfigFlag('gdm/is_initialized')) {
            return;
        }

        $this->_deactivateCache();

        // redirect to gdm form
        header('Location: ' . Mage::helper('adminhtml')->getUrl('adminhtml/gdm'));
        exit;
    }

    protected  function _deactivateCache()
    {
        /* @var $cache Mage_Core_Model_Cache */
        $cache = Mage::getModel('core/cache');

        /* @var $options array */
        $options = $cache->canUse(null);

        $newOptions = array();
        foreach ($options as $option => $value) {
            $newOptions[$option] = 0;
        }

        $cache->saveOptions($newOptions);
    }
}