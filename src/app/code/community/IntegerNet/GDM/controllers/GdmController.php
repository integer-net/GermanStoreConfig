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
        if ($this->getRequest()->isPost()) {

        }

        $this->_markNotificationsAsRead();

        $this->_runGermanSetup();

        $this->_reindexAll();

        Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Magento was prepared successfully.'));

        // Set a config flag to indicate that the setup has been initialized.
        Mage::getModel('eav/entity_setup', 'core_setup')->setConfigData('gdm/is_initialized', '1');

        $this->_redirect('');
    }


    protected function _reindexAll()
    {
        $processCollection = Mage::getModel('index/process')->getCollection();

        foreach ($processCollection as $process) {
            /* @var $process Mage_Index_Model_Process */
            $process->reindexAll();
        }
    }

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

    protected function _runGermanSetup()
    {
        Mage::getSingleton('germansetup/setup')->setup();
    }
}
