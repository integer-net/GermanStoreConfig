<?php

/* @var $installer IntegerNet_GermanStoreConfig_Model_Setup */
$installer = $this;

/** @var $pollCollection Mage_Poll_Model_Resource_Poll_Collection */
$pollCollection = Mage::getModel('poll/poll')->getCollection();
foreach($pollCollection as $poll) {
    /** @var $poll Mage_Poll_Model_Poll */
    $poll->delete();
}

$installer->endSetup();