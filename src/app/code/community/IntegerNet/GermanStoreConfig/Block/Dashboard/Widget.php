<?php

class IntegerNet_GermanStoreConfig_Block_Dashboard_Widget extends Mage_Adminhtml_Block_Template
{
    public function displayWidget()
    {
        return Mage::getStoreConfigFlag('admin/germanstoreconfig/display_dashboard_block');
    }

    public function getIframeUrl()
    {
        $iframeUrl = Mage::getStoreConfig('germanstoreconfig/iframe_url_prefix')
            . $this->_getLanguageUrlPart()
            . '/dashboard-widget'
            . Mage::getStoreConfig('germanstoreconfig/iframe_url_suffix');

        return $iframeUrl;
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