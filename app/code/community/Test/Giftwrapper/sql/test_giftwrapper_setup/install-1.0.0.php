<?php
/**
 * @author      Andrey Makienko <makyshplat@gmail.com>
 */
/** @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
$entityTypeId = Mage_Catalog_Model_Product::ENTITY;
$availableAttributes = [
    'can_wrapped' => ['label' => 'Can Wrapped', 'default' => '1'],
    'is_giftwrapper_product' => ['label' => 'Is Gift Wrapper Product', 'default' => '0']
];

foreach ($availableAttributes as $attributeCode => $attributeLabel) {
    $installer
        ->removeAttribute($entityTypeId, $attributeCode)
        ->addAttribute($entityTypeId, $attributeCode, array(
        'group' => Test_Giftwrapper_Helper_Data::TEST_GIFT_WRAPPER_PRODUCT_GROUP,
        'input' => 'select',
        'type' => 'int',
        'label' => $attributeLabel['label'],
        'source' => 'eav/entity_attribute_source_boolean',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => 1,
        'required' => 0,
        'visible_on_front' => 0,
        'is_html_allowed_on_front' => 0,
        'is_configurable' => 0,
        'searchable' => 0,
        'filterable' => 0,
        'comparable' => 0,
        'unique' => false,
        'user_defined' => true,
        'default' => $attributeLabel['default'],
        'is_user_defined' => false,
        'used_in_product_listing' => false
    ));
}

$installer->endSetup();