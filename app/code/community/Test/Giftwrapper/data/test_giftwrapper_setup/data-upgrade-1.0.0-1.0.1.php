<?php
/**
 * @author      Andrey Makienko <makyshplat@gmail.com>
 */
/** @var Mage_Catalog_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();
$entityTypeId = Mage_Catalog_Model_Product::ENTITY;
$productEntityTypeId = Mage::getSingleton('eav/config')->getEntityType($entityTypeId)->getId();

$websitesIds = [];
foreach (Mage::app()->getWebsites() as $website) {
    $websitesIds[] = $website->getWebsiteId();
}

$availableWebsitesIds = implode(',', $websitesIds);

$attributeSetId = Mage::getModel('eav/entity_attribute_set')
    ->getCollection()
    ->setEntityTypeFilter($productEntityTypeId)
    ->addFieldToFilter('attribute_set_name', 'Default')
    ->getFirstItem()
    ->getAttributeSetId();
try {
    $product = Mage::getModel('catalog/product');
    if (!$product->loadByAttribute('sku', Test_Giftwrapper_Helper_Data::TEST_GIFT_WRAPPER_PRODUCT_SKU)) {
        $product
            ->setWebsiteIds([$availableWebsitesIds])//website ID the product is assigned to, as an array
            ->setAttributeSetId($attributeSetId)//ID of a attribute set named 'default'
            ->setTypeId(Mage_Catalog_Model_Product_Type::TYPE_SIMPLE)//product type
            ->setCreatedAt(strtotime('now'))
            ->setSku(Test_Giftwrapper_Helper_Data::TEST_GIFT_WRAPPER_PRODUCT_SKU)//SKU
            ->setName(Test_Giftwrapper_Helper_Data::TEST_GIFT_WRAPPER_PRODUCT_NAME)//product name
            ->setWeight(1.0000)
            ->setCanWrapped(0)
            ->setIsGiftwrapperProduct(1)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setTaxClassId(0)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
            ->setPrice(Test_Giftwrapper_Helper_Data::TEST_GIFT_WRAPPER_PRODUCT_PRICE)
            ->setDescription(Test_Giftwrapper_Helper_Data::TEST_GIFT_WRAPPER_PRODUCT_DESCRIPTION)
            ->setShortDescription(Test_Giftwrapper_Helper_Data::TEST_GIFT_WRAPPER_PRODUCT_DESCRIPTION)
            ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock'            => 0,
                    'min_sale_qty'            => 1,
                    'max_sale_qty'            => 2,
                    'is_in_stock'             => 1, //Stock Availability
                    'qty'                     => 100000 //qty
                )
            );
        $product->save();

    }
} catch (Exception $e) {
    Mage::log($e->getMessage());
}
$installer->endSetup();