<?php
class IntegerNet_GDM_GdmController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Basic action: setup form
     *
     * @return void
     */
    public function indexAction()
    {
        $helper = Mage::helper('gdm');

        $this->_title($helper->__('System'))
            ->_title($helper->__('German Distribution for Magento'));

        $this->loadLayout()
            ->_setActiveMenu('system/gdm')
            ->_addBreadcrumb($helper->__('German Distribution for Magento'), $helper->__('German Distribution for Magento'));

        $this->getLayout()
            ->getBlock('content')
            ->append($this->getLayout()->createBlock('gdm/form'));

        $this->renderLayout();
    }

    /**
     * Basic action: setup save action
     *
     * @return void
     */
    public function saveAction()
    {
        if ($this->getRequest()->isPost()) {

        }
        $this->_redirect('*/*');
    }
}
