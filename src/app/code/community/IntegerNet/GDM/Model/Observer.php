<?php
class IntegerNet_GDM_Model_Observer
{
    public function predispatchInstallWizard($observer)
    {
        Mage::getSingleton('install/session')->setTimezone('Europe/Berlin');
        Mage::getSingleton('install/session')->setCurrency('EUR');
    }
}