<?php

class IntegerNet_GermanStoreConfig_Block_Tracking extends Mage_Adminhtml_Block_Template
{
    public function getImageUrl()
    {
        return Mage::getStoreConfig('germanstoreconfig/tracking_url');
    }

    public function showTracking()
    {
        if (Mage::getStoreConfig('admin/germanstoreconfig/datatransfer') == IntegerNet_GermanStoreConfig_Model_Source_Datatransfer::DATATRANSFER_NONE) {
            return false;
        }

        return true;
    }
}
