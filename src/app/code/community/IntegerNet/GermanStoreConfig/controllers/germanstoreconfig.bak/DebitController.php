<?php
class IntegerNet_GermanStoreConfig_Germanstoreconfig_DebitController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_forward('edit', 'system_config', null, array('section' => 'payment'));
    }

    public function bankdatasetupAction()
    {
        $this->_forward('edit', 'system_config', null, array('section' => 'debitpayment'));
    }
}
