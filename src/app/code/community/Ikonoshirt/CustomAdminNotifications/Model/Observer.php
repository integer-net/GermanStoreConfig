<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category  Ikonoshirt
 * @package   Ikonoshirt_CustomAdminNotifications
 * @author    Fabian Blechschmidt <hackathon@fabian-blechschmidt.de>
 * @copyright 2012 Ikonoshirt, Fabian Blechschmidt
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.ikonoshirt.de/
 */

/**
 * Ikonoshirt_CustomAdminNotifications observer
 */
class Ikonoshirt_CustomAdminNotifications_Model_Observer
{
    /**
     * Predispatch action controller
     */
    public function preDispatch()
    {
        /* @var $session Mage_Admin_Model_Session */
        $session = Mage::getSingleton('admin/session');
        if ($session->isLoggedIn()) {
            $feedModel = Mage::getModel(
                'ikonoshirt_customadminnotifications/feed'
            );

            /* @var $feedModel Mage_AdminNotification_Model_Feed */
            $feedModel->checkUpdate();
        }

    }
}
