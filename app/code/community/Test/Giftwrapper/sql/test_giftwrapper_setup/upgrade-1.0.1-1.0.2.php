<?php
/**
 * @author      Andrey Makienko <makyshplat@gmail.com>
 */
/** @var $this Mage_Catalog_Model_Resource_Setup */
$this->startSetup();

$addressTypeField= [
    'gift_parent_item_id' => 'Gift parent item',
];

foreach ($addressTypeField as $code => $label) {

    if (!$this->getConnection()->tableColumnExists($this->getTable('sales/quote_item'), $code)) {
        $this->getConnection()->addColumn(
            $this->getTable('sales/quote_item'),
            $code,
            array(
                'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'unsigned' => true,
                'length' => '10',
                'nullable' => true,
                'comment' => $label,
            )
        );
    }
}
$this->endSetup();