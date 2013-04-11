<?php
class IntegerNet_GermanStoreConfig_Model_Observer
{
    /**
     * Set theme to "germanstoreconfig" with fallback to "default"
     *
     * @param Varien_Event_Observer $observer
     * @event controller_action_predispatch_install_wizard_begin
     * @event controller_action_predispatch_install_wizard_locale
     * @event controller_action_predispatch_install_wizard_config
     * @event controller_action_predispatch_install_wizard_administrator
     * @event controller_action_predispatch_install_wizard_end
     */
    public function predispatchInstallWizard($observer)
    {
        Mage::getDesign()->setTheme('germanstoreconfig');
    }

    /**
     * Set default Timezone and Currency
     *
     * @param Varien_Event_Observer $observer
     * @event controller_action_predispatch_install_wizard_index
     * @event controller_action_predispatch_install_index_index
     */
    public function predispatchInstallStart($observer)
    {
        Mage::getSingleton('install/session')->setTimezone(Mage::getStoreConfig('germanstoreconfig/timezone'));
        Mage::getSingleton('install/session')->setCurrency(Mage::getStoreConfig('germanstoreconfig/currency'));
    }

    /**
     * If Freeshipping method is allowed, disallow all other shipping methods
     *
     * @param Varien_Event_Observer $observer
     * @return void
     * @event core_collection_abstract_load_after
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

    /**
     * Add copyright notice to end of imprint cms page
     *
     * @param Varien_Event_Observer $observer
     * @event cms_page_load_after
     */
    public function afterLoadCmsPage(Varien_Event_Observer $observer)
    {
        /** @var $page Mage_Cms_Model_Page */
        $page = $observer->getObject();
        if ($page->getIdentifier() == 'impressum' && Mage::getStoreConfigFlag('general/imprint/display_copyright')) {
            $copyrightHtml = Mage::app()->getLayout()
                ->createBlock('germanstoreconfig/frontend_copyright', 'copyright')
                ->setTemplate('germanstoreconfig/copyright.phtml')
                ->toHtml();
            $page->setContent($page->getContent() . $copyrightHtml);
        }
    }

    /**
     * Add additional text to checkout review page if "cash on delivery" payment method is selected
     *
     * @param Varien_Event_Observer $observer
     * @event checkout_additional_information
     */
    public function addCheckoutAdditionalInformation(Varien_Event_Observer $observer)
    {
        /** @var $quote Mage_Sales_Model_Quote */
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        if ($quote->getPayment()->getMethod() == 'cashondelivery') {

            $customText = $quote->getPayment()->getMethodInstance()->getCustomText();

            if ($customText) {
                $additionalObject = $observer->getAdditional();
                $text = (string)$additionalObject->getText();

                if ($text) {
                    $text .= '<br />';
                }

                $text .= $customText;
                $additionalObject->setText($text);
            }
        }
    }
}