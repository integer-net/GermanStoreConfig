<?php

/**
 * @category   AvS
 * @package    AvS_AdminNotificationAdvanced
 * @author     Andreas von Studnitz <avs@avs-webentwicklung.de>
 */
class AvS_AdminNotificationAdvanced_NotificationadvancedController extends Mage_Adminhtml_Controller_Action {

    /**
     * Mark all unread messages as read
     *
     * @return void
     */
    public function markallreadAction()
    {
        $notices = Mage::getModel('adminnotification/inbox')->getCollection()
            ->addFieldToFilter('is_read', 0)
            ->addFieldToFilter('is_remove', 0);

        foreach($notices as $notice) {
            $notice
                ->setIsRead(1)
                ->save();
        }

        $this->_redirectReferer();
    }

    /**
     * Mark all messages as deleted
     *
     * @return void
     */
    public function deleteallAction()
    {
        $notices = Mage::getModel('adminnotification/inbox')->getCollection()
            ->addFieldToFilter('is_remove', 0);
        
        foreach($notices as $notice) {
            $notice
                ->setIsRemove(1)
                ->save();
        }

        $this->_redirectReferer();
    }
}
