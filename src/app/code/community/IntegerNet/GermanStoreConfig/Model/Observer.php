<?php
class IntegerNet_GermanStoreConfig_Model_Observer
{
    /**
     * Set theme to "germanstoreconfig" with fallback to "default"
     *
     * @param Varien_Event_Observer $observer
     */
    public function predispatchInstallWizard($observer)
    {
        Mage::getDesign()->setTheme('germanstoreconfig');
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
     * If Freeshipping method is allowed, disallow all other shipping methods
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function afterLoadCollection($observer)
    {
        $collection = $observer->getCollection();

        if (!$collection instanceof Mage_Sales_Model_Resource_Quote_Address_Rate_Collection) return;

        if (!$this->_isFreeshippingIncluded($collection)) return;

        $shippingAddress = Mage::getSingleton('checkout/session')
            ->getQuote()
            ->getShippingAddress();

        $shippingAddress->setLimitCarrier('freeshipping');
    }

    /**
     * Checks if freeshipping method is included in collection for available shipping methods
     *
     * @param Mage_Sales_Model_Resource_Quote_Address_Rate_Collection $rateCollection
     * @return boolean
     */
    protected function _isFreeshippingIncluded($rateCollection)
    {
        foreach ($rateCollection as $rate) {

            /** @var $rate Mage_Sales_Model_Quote_Address_Rate */
            if ($rate->getMethod() == 'freeshipping') {
                return true;
            }
        }
        return false;
    }
}