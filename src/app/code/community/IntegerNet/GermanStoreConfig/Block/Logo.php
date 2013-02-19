<?php

class IntegerNet_GermanStoreConfig_Block_Logo extends Mage_Adminhtml_Block_Template
{
    /**
     * @return bool
     */
    public function isActive()
    {
        return Mage::getStoreConfigFlag('admin/germanstoreconfig/display_logo');
    }

    /**
     * @return string
     */
    public function getLinkUrl()
    {
        return Mage::getStoreConfig('germanstoreconfig/url');
    }

    /**
     * Get language dependant URL of germanstoreconfig logo
     *
     * @return string
     */
    public function getLogoUrl()
    {
        $localeCode = Mage::app()->getLocale()->getLocaleCode();
        if (strpos($localeCode, 'de_') === 0) {
            return $this->getSkinUrl('images/logo-germanstoreconfig-de.gif');
        } else {
            return $this->getSkinUrl('images/logo-germanstoreconfig-en.gif');
        }
    }

    /**
     * @return string
     */
    public function getLogoAlt()
    {
        return Mage::helper('germanstoreconfig')->__('German Store Configuration for Magento CE');
    }
}
