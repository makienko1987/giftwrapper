<?php
/**
 * @author      Andrey Makienko <makyshplat@gmail.com>
 */
/** @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
$tableName = $installer->getTable('sales/quote_item');
// Check if the table already exists
if ($installer->getConnection()->isTableExists($tableName)) {
    $table = $installer->getConnection();
    $table->addIndex(
        $tableName,
        $installer->getIdxName('sales/quote_item', array('gift_parent_item_id')),
        array('gift_parent_item_id')
    );
}
$installer->endSetup();