<?php
class IntegerNet_GermanStoreConfig_Germanstoreconfig_GermansetupController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_forward('index', 'germansetup');
    }

    public function taxAction()
    {
        $this->_forward('index', 'tax_rule');
    }

    public function agreementsAction()
    {
        $this->_forward('index', 'checkout_agreement');
    }
}
