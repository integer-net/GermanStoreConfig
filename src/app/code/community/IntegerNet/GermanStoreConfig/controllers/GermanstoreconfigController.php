<?php
class IntegerNet_GermanStoreConfig_GermanstoreconfigController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $helper = Mage::helper('germanstoreconfig');

        $this->_title($helper->__(Mage::getStoreConfig('germanstoreconfig/module_title')))
            ->_title($helper->__('Dashboard'));

        $this->loadLayout()
            ->_setActiveMenu('germanstoreconfig/dashboard')
            ->_addBreadcrumb($helper->__('Dashboard'), $helper->__('Dashboard'));

        $iframeUrl = Mage::getStoreConfig('germanstoreconfig/iframe_url_prefix')
            . $this->_getLanguageUrlPart()
            . '/dashboard'
            . Mage::getStoreConfig('germanstoreconfig/iframe_url_suffix');

        $this->getLayout()
            ->getBlock('content')
            ->append(
                $this->getLayout()
                    ->createBlock('adminhtml/template')
                    ->setTemplate('germanstoreconfig/iframe.phtml')
                    ->setIframeUrl($iframeUrl)
            );

        $this->renderLayout();
    }

    public function partnerAction()
    {
        $helper = Mage::helper('germanstoreconfig');

        $this->_title($helper->__(Mage::getStoreConfig('germanstoreconfig/module_title')))
            ->_title($helper->__('Partners'));

        $this->loadLayout()
            ->_setActiveMenu('germanstoreconfig/dashboard/partner')
            ->_addBreadcrumb($helper->__('Partners'), $helper->__('Partners'));

        $iframeUrl = Mage::getStoreConfig('germanstoreconfig/iframe_url_prefix')
            . $this->_getLanguageUrlPart()
            . '/exclusive-partners'
            . Mage::getStoreConfig('germanstoreconfig/iframe_url_suffix');
        $this->getLayout()
            ->getBlock('content')
            ->append(
                $this->getLayout()
                    ->createBlock('adminhtml/template')
                    ->setTemplate('germanstoreconfig/iframe.phtml')
                    ->setIframeUrl($iframeUrl)
            );

        $this->renderLayout();
    }

    public function suggestionsAction()
    {
        $helper = Mage::helper('germanstoreconfig');

        $this->_title($helper->__(Mage::getStoreConfig('germanstoreconfig/module_title')))
            ->_title($helper->__('Suggestions'));

        $this->loadLayout()
            ->_setActiveMenu('germanstoreconfig/dashboard/suggestions')
            ->_addBreadcrumb($helper->__('Suggestions'), $helper->__('Suggestions'));

        $iframeUrl = Mage::getStoreConfig('germanstoreconfig/iframe_url_prefix')
            . $this->_getLanguageUrlPart()
            . '/suggestions'
            . Mage::getStoreConfig('germanstoreconfig/iframe_url_suffix');
        $this->getLayout()
            ->getBlock('content')
            ->append(
                $this->getLayout()
                    ->createBlock('adminhtml/template')
                    ->setTemplate('germanstoreconfig/iframe.phtml')
                    ->setIframeUrl($iframeUrl)
            );

        $this->renderLayout();
    }

    /**
     * Basic action: setup form
     *
     * @return void
     */
    public function formAction()
    {
        $helper = Mage::helper('germanstoreconfig');

        $this->_title($helper->__('System'))
            ->_title($helper->__(Mage::getStoreConfig('germanstoreconfig/module_title')));

        if (Mage::getStoreConfigFlag('admin/germanstoreconfig/display_menu')) {
            $this->loadLayout()
                ->_addBreadcrumb($helper->__(Mage::getStoreConfig('germanstoreconfig/module_title')), $helper->__(Mage::getStoreConfig('germanstoreconfig/module_title')))
                ->_setActiveMenu('germanstoreconfig/configuration');
        } else {
            $this->loadLayout()
                ->_addBreadcrumb($helper->__(Mage::getStoreConfig('germanstoreconfig/module_title')), $helper->__(Mage::getStoreConfig('germanstoreconfig/module_title')))
                ->_setActiveMenu('system/germanstoreconfig');
        }

        $this->getLayout()
            ->getBlock('content')
            ->append($this->getLayout()->createBlock('germanstoreconfig/form'));

        $this->getLayout()
            ->getBlock('root')
            ->unsetChild('notifications');

        $this->renderLayout();
    }

    /**
     * Basic action: setup save action
     *
     * @return void
     */
    public function saveAction()
    {
        if (!Mage::getStoreConfig('germanstoreconfig/is_initialized')) {
            $this->_deactivateCache();
        }

        $this->_updateConfigData();

        $this->_createStores();

        if (!Mage::getStoreConfig('germanstoreconfig/is_initialized')) {

            $this->_markNotificationsAsRead();

            $this->_runGermanSetup();

            $this->_reindexAll();

            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Magento was prepared successfully.'));

            // Set a config flag to indicate that the setup has been initialized.
            $this->_setConfigData('germanstoreconfig/is_initialized', 1);

        } else {

            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Your data was saved successfully.'));
        }


        $this->_redirect('');
    }

    /**
     * Update configuration based on form entries
     */
    public function _updateConfigData()
    {
        if ($this->getRequest()->isPost()) {

            $fieldData = $this->getRequest()->getParam('field');
            if (is_array($fieldData)) {
                foreach ($fieldData as $key => $value) {
                    $fieldCode = implode('/', explode('__', $key));
                    $this->_setConfigData($fieldCode, $value);
                }
                $this->_setConfigData('general/store_information/name', $fieldData['general__imprint__shop_name']);
                $this->_setConfigData('general/store_information/phone', $fieldData['general__imprint__telephone']);
                $this->_setConfigData('general/store_information/merchant_vat_number', $fieldData['general__imprint__vat_id']);
                $this->_setConfigData('general/store_information/address', $this->_getAddress($fieldData));
                $this->_setConfigData('sales/identity/address', $this->_getAddress($fieldData));
                $this->_setConfigData('design/head/default_title', $fieldData['general__imprint__shop_name']);
                $this->_setConfigData('design/head/title_suffix', ' - ' . $fieldData['general__imprint__shop_name']);
                $this->_setConfigData('design/head/default_description', $fieldData['general__imprint__shop_name']);
                $this->_setConfigData('design/head/default_keywords', $fieldData['general__imprint__shop_name']);
                $this->_setConfigData('design/header/logo_alt', $fieldData['general__imprint__shop_name']);
                $this->_setConfigData('design/footer/copyright', '&copy; ' . date('Y') . ' ' . $fieldData['general__imprint__company_first']);
                $this->_setConfigData('trans_email/ident_general/name', $fieldData['general__imprint__shop_name']);
                $this->_setConfigData('trans_email/ident_general/email', $fieldData['general__imprint__email']);
                $this->_setConfigData('trans_email/ident_sales/name', $fieldData['general__imprint__shop_name']);
                $this->_setConfigData('trans_email/ident_sales/email', $fieldData['general__imprint__email']);
                $this->_setConfigData('trans_email/ident_support/name', $fieldData['general__imprint__shop_name']);
                $this->_setConfigData('trans_email/ident_support/email', $fieldData['general__imprint__email']);
                $this->_setConfigData('trans_email/ident_custom1/name', $fieldData['general__imprint__shop_name']);
                $this->_setConfigData('trans_email/ident_custom1/email', $fieldData['general__imprint__email']);
                $this->_setConfigData('trans_email/ident_custom2/name', $fieldData['general__imprint__shop_name']);
                $this->_setConfigData('trans_email/ident_custom2/email', $fieldData['general__imprint__email']);
                $this->_setConfigData('contacts/email/recipient_email', $fieldData['general__imprint__email']);
                $this->_setConfigData('sales_email/order/copy_to', $fieldData['general__imprint__email']);
                $this->_setConfigData('sales_pdf/firegento_pdf/sender_address_bar', $this->_getAddress($fieldData, ' - '));
                $this->_setConfigData('checkout/payment_failed/copy_to', $fieldData['general__imprint__email']);
                $this->_setConfigData('shipping/origin/postcode', $fieldData['general__imprint__zip']);
                $this->_setConfigData('shipping/origin/city', $fieldData['general__imprint__city']);
                $this->_setConfigData('shipping/origin/street_line1', $fieldData['general__imprint__street']);
                $this->_setConfigData('payment/banktransfer/instructions', $this->__(
                    'After completion of this order, please transfer the order amount to: %s, Account %s, Bank number %s, %s (IBAN %s, SWIFT %s)',
                    $fieldData['general__imprint__bank_account_owner'],
                    $fieldData['general__imprint__bank_account'],
                    $fieldData['general__imprint__bank_code_number'],
                    $fieldData['general__imprint__bank_name'],
                    $fieldData['general__imprint__iban'],
                    $fieldData['general__imprint__swift']
                ));
                $this->_setConfigData('debitpayment/bankaccount/account_owner', $fieldData['general__imprint__bank_account_owner']);
                $this->_setConfigData('debitpayment/bankaccount/routing_number', $fieldData['general__imprint__bank_code_number']);
                $this->_setConfigData('debitpayment/bankaccount/account_number', $fieldData['general__imprint__bank_account']);

                $defaultStore = Mage::app()->getDefaultStoreView();
                if ($defaultStore->getId()) {
                    $defaultStore
                        ->setName(Mage::getStoreConfig('germanstoreconfig/default_language/name'))
                        ->setCode(Mage::getStoreConfig('germanstoreconfig/default_language/code'))
                        ->save();
                }
                $defaultStoreGroup = $defaultStore->getGroup();
                if ($defaultStoreGroup->getId()) {
                    $defaultStoreGroup
                        ->setName($fieldData['general__imprint__shop_name'])
                        ->save();
                }
                $defaultWebsite = $defaultStore->getWebsite();
                if ($defaultWebsite->getId()) {
                    $defaultWebsite
                        ->setName($fieldData['general__imprint__shop_name'])
                        ->save();
                }
                $defaultCategory = Mage::getModel('catalog/category')
                    ->getCollection()
                    ->addAttributeToFilter('name', 'Default Category')
                    ->getFirstItem();
                if ($defaultCategory->getId()) {
                    $defaultCategory->setName($this->__('Default Category'))->save();
                }
            }

            $payPalEmailAddress = $this->getRequest()->getParam('paypal_email');
            if ($payPalEmailAddress) {
                $this->_setConfigData('paypal/general/business_account', $payPalEmailAddress);
                $this->_setConfigData('payment/paypal_standard/active', 1);
                $this->_setConfigData('payment/paypal_standard/title', 'PayPal');
                $this->_setConfigData('payment/paypal_standard/sort_order', 10);
            }
        }

        $this->_setConfigData('general/region/state_required', '');
        $this->_setConfigData('general/region/display_all', 0);
        $this->_setConfigData('admin/startup/page', 'dashboard');

        if (!Mage::getStoreConfig('germanstoreconfig/is_initialized')) {

            $this->_setConfigData('germanstoreconfig/installation_id', md5(Mage::getBaseUrl()));
            date_default_timezone_set(Mage::getStoreConfig('general/locale/timezone'));
            $installationDate = new Zend_Date();
            $this->_setConfigData('germanstoreconfig/installation_date', $installationDate->get(Zend_Date::ISO_8601));
        }
    }

    /**
     * Return formatted company address
     *
     * @param array $fieldData
     * @param string $seperator
     * @return string
     */
    protected function _getAddress($fieldData, $seperator = "\n")
    {
        $address = ($fieldData['general__imprint__company_first'] ? $fieldData['general__imprint__company_first'] . $seperator : '');
        $address .= ($fieldData['general__imprint__company_second'] ? $fieldData['general__imprint__company_second'] . $seperator : '');
        $address .= ($fieldData['general__imprint__street'] ? $fieldData['general__imprint__street'] . $seperator : '');
        $address .= ($fieldData['general__imprint__zip'] ? $fieldData['general__imprint__zip'] . ' ' : '');
        $address .= ($fieldData['general__imprint__city'] ? $fieldData['general__imprint__city'] : '');
        return $address;
    }

    /**
     * Set configuration data
     *
     * @param string $key
     * @param string|int $value
     * @param string $scope
     * @param int $scopeId
     */
    protected function _setConfigData($key, $value, $scope = 'default', $scopeId = 0)
    {
        Mage::getModel('eav/entity_setup', 'core_setup')->setConfigData($key, $value, $scope, $scopeId);
    }

    /**
     * Create Stores with different languages
     */
    public function _createStores()
    {
        if ($this->getRequest()->isPost()) {

            $languageData = $this->getRequest()->getParam('language');
            if (is_array($languageData)) {
                $i = 0;
                $storeCreated = false;
                foreach ($languageData as $localeCode => $value) {
                    if ($value != 1) {
                        continue;
                    }

                    $storeCreated = $this->_createStore($localeCode, $i) || $storeCreated;
                }

                if ($storeCreated) {
                    $this->_setConfigData('web/url/use_store', 1);
                }
            }
        }
    }

    /**
     * @param string $localeCode (i.e. en_US or fr_FR)
     * @param int $i
     * @return boolean
     */
    protected function _createStore($localeCode, &$i)
    {
        $languageCode = array_shift(explode('_', $localeCode));
        /** @var $store Mage_Core_Model_Store */
        $store = Mage::getModel('core/store');
        $store->load($languageCode, 'code');
        if ($store->getId()) {
            $this->_getSession()->addNotice($this->__('Store "%s" already exists.', $languageCode));
            return false;
        }
        $store
            ->setCode($languageCode)
            ->setName($this->__(Mage::getStoreConfig('germanstoreconfig/available_languages/' . $localeCode)))
            ->setWebsiteId(Mage::app()->getDefaultStoreView()->getWebsiteId())
            ->setGroupId(Mage::app()->getDefaultStoreView()->getGroupId())
            ->setIsActive(1)
            ->setSortOrder(++$i)
            ->save();

        $this->_setConfigData('general/locale/code', $localeCode, 'stores', $store->getId());

        return true;
    }

    /**
     * Reindex all indices
     */
    protected function _reindexAll()
    {
        $processCollection = Mage::getModel('index/process')->getCollection();

        foreach ($processCollection as $process) {
            /* @var $process Mage_Index_Model_Process */
            $process->reindexAll();
        }
    }

    /**
     * Mark all notifications as read
     */
    protected function _markNotificationsAsRead()
    {
        $notificationCollection = Mage::getModel('adminnotification/inbox')->getCollection();
        foreach ($notificationCollection as $notification) {
            /* @var $notification Mage_AdminNotification_Model_Inbox */
            if (!$notification->getIsRead()) {
                $notification->setIsRead(1)
                    ->save();
            }
        }
    }

    /**
     * Run Setup of GermanSetup as if the form had been filled and submitted
     */
    protected function _runGermanSetup()
    {
        Mage::getSingleton('germansetup/setup')->setup();
    }

    /**
     * Deactivate all caches
     */
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

    public function newsAction()
    {
        $this->_forward('index', 'notification');
    }

    /**
     * @return string
     */
    protected function _getLanguageUrlPart()
    {
        $localeCode = Mage::app()->getLocale()->getLocaleCode();
        if (strpos($localeCode, 'de_') === 0) {
            return 'de';
        } else {
            return 'en';
        }
    }
}
