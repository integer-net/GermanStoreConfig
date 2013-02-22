<?php

class IntegerNet_GermanStoreConfig_Block_News extends Mage_Adminhtml_Block_Template
{
    /**
     * @return array
     */
    public function getNewsItems()
    {
        $feedUrl = Mage::getStoreConfig('germanstoreconfig/newsfeed_url');

        $httpClient = new Zend_Http_Client($feedUrl);

        $response = $httpClient->request();

        $news = new Varien_Simplexml_Element($response->getBody());

        foreach ($news->channel->item as $item) {
            $date = new Zend_Date((string)$item->pubDate, Zend_Date::RFC_822);
            $items[$date->get(Zend_Date::TIMESTAMP)] = new Varien_Object(array(
                'title' => (string)$item->title,
                'description' => (string)$item->description,
                'date' => $date->get(Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM)),
                'link' => (string)$item->link,
            ));
        }

        krsort($items);

        return $items;
    }
}
