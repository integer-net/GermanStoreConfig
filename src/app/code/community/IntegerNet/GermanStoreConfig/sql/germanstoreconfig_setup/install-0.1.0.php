<?php

/* @var $installer IntegerNet_GermanStoreConfig_Model_Setup */
$installer = $this;

// translate attribute labels
$attributesSqlFilename = Mage::getBaseDir('locale') . DS . 'de_DE' . DS . 'sql_translation' . DS . 'attributes.sql';

if (file_exists($attributesSqlFilename)) {

    // run script only if no database table prefix is set
    if ($this->getTable('poll') == 'poll') {

        $attributesSql = file_get_contents($attributesSqlFilename);
        // question marks break the installer as they are intended as placeholders
        $attributesSql = str_replace('?', '&quest;', $attributesSql);
        $installer->run($attributesSql);
    }
}

// remove all polls
$installer->run("
    DELETE FROM {$this->getTable('poll')};
");

$installer->endSetup();