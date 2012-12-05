<?php

/* @var $installer IntegerNet_GDM_Model_Setup */
$installer = $this;

$attributesSqlFilename = Mage::getBaseDir('locale') . DS . 'de_DE' . DS . 'sql_translation' . DS . 'attributes.sql';

if (file_exists($attributesSqlFilename)) {

    $attributesSql = file_get_contents($attributesSqlFilename);
    $attributesSql = str_replace('?', '&quest;', $attributesSql);
    $installer->run($attributesSql);
}

$installer->endSetup();