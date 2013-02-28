<?php
class IntegerNet_GermanStoreConfig_Block_Frontend_Copyright extends Mage_Core_Block_Template
{
    public function getMagentoDEUrl()
    {
        $localeCode = Mage::app()->getLocale()->getLocaleCode();
        if (strpos($localeCode, 'de_') === 0) {
            return Mage::getStoreConfig('germanstoreconfig/magentode_url_de');
        } else {
            return Mage::getStoreConfig('germanstoreconfig/magentode_url_en');
        }
    }

    public function getAppFactoryUrl()
    {
        $localeCode = Mage::app()->getLocale()->getLocaleCode();
        if (strpos($localeCode, 'de_') === 0) {
            return Mage::getStoreConfig('germanstoreconfig/appfactory_url_de');
        } else {
            return Mage::getStoreConfig('germanstoreconfig/appfactory_url_en');
        }
    }

    public function getIntegerNetUrl()
    {
        $localeCode = Mage::app()->getLocale()->getLocaleCode();
        if (strpos($localeCode, 'de_') === 0) {
            return Mage::getStoreConfig('germanstoreconfig/integernet_url_de');
        } else {
            return Mage::getStoreConfig('germanstoreconfig/integernet_url_en');
        }
    }
}