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

    /**
     * Adds GermanStoreConfig Logo to adminhtml header
     *
     * @param Varien_Event_Observer $observer
     */
    public function afterAdminhtmlBlockHtml($observer)
    {
        $block = $observer->getBlock();
        if ($block instanceof Mage_Adminhtml_Block_Page_Header && Mage::getStoreConfigFlag('admin/germanstoreconfig/display_logo')) {

            $transport = $observer->getTransport();
            $html = $transport->getHtml();
            $divider = '<div class="header-right">';
            $dividerPos = strpos($html, $divider);
            $htmlBeforeDivider = substr($html, 0, $dividerPos);
            $htmlAfterDivider = substr($html, $dividerPos);

            $linkUrl = '';
            $logoUrl = $this->_getLogoUrl($block);
            $logoAlt = Mage::helper('germanstoreconfig')->__('German Store Configuration for Magento CE');

            $newHtml = '<a href="' . $linkUrl . '" target="_blank">';
            $newHtml .= '<img class="logo" src="' . $logoUrl . '" alt="' . $logoAlt . '" />';
            $newHtml .= '</a>';

            $transport->setHtml($htmlBeforeDivider . $newHtml . $htmlAfterDivider);
        }
    }

    /**
     * Get language dependant URL of germanstoreconfig logo
     *
     * @param Mage_Adminhtml_Block_Page_Header $block
     * @return string
     */
    protected function _getLogoUrl($block)
    {
        $localeCode = Mage::app()->getLocale()->getLocaleCode();
        if (strpos($localeCode, 'de_') === 0) {
            return $block->getSkinUrl('images/logo-germanstoreconfig-de.gif');
        } else {
            return $block->getSkinUrl('images/logo-germanstoreconfig-en.gif');
        }
    }
}