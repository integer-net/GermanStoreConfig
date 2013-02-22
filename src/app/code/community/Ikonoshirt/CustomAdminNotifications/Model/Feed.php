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
class Ikonoshirt_CustomAdminNotifications_Model_Feed
    extends Mage_AdminNotification_Model_Feed
{
    const XML_FEEDS_PATH = 'ikonoshirt/custom_rss_feeds/feeds';

    public function checkUpdate()
    {
        $feeds = $this->getAllFeeds();
        if (!is_array($feeds)) {
            Mage::log('Ikonoshirt_CustomAdminNotifications: No feeds found.');
            return $this;
        }

        if (($this->getFrequency() + $this->getLastUpdate())
            > time()
        ) {
            return $this;
        }

        /* @var $inbox Mage_AdminNotification_Model_Inbox */
        $inbox = Mage::getModel('adminnotification/inbox');
        foreach ($feeds as $feed) {

            // IMPORTANT
            // in getFeedData $this->getFeedUrl() is called,
            // which returns $this->_feedUrl
            // to not overwrite this method, I set this attribute.
            $this->_feedUrl = $feed;

            $feedData = array();

            $feedXml = $this->getFeedData($feed);

            if ($feedXml && $feedXml->channel && $feedXml->channel->item) {
                foreach ($feedXml->channel->item as $item) {
                    $feedData[] = array(
                        'severity'    =>
                        (int)isset($item->severity) ? $item->severity
                        : Mage_AdminNotification_Model_Inbox::SEVERITY_NOTICE,
                        'date_added'  => $this->getDate((string)$item->pubDate),
                        'title'       => (string)$item->title,
                        'description' => (string)$item->description,
                        'url'         => ( $item->link ? (string)$item->link : null ),
                    );
                }

                if ($feedData) {
                    $inbox->parse(array_reverse($feedData));
                }
            }
            $this->setLastUpdate($feed);
        }
        return $this;
    }

    /**
     * @return array
     */
    protected function getAllFeeds()
    {
        $feeds = Mage::getStoreConfig(self::XML_FEEDS_PATH);
        return $feeds;
    }

    /**
     * Retrieve Last update time
     *
     * @return int
     */
    public function getLastUpdate()
    {
        return Mage::app()->loadCache('ikonoshirt_custom_admin_notifications');
    }

    /**
     * Set last update time (now)
     *
     * @return Mage_AdminNotification_Model_Feed
     */
    public function setLastUpdate()
    {
        Mage::app()->saveCache(time(), 'ikonoshirt_custom_admin_notifications');
        return $this;
    }
}