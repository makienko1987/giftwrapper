<?php
/**
 * @author      Andrey Makienko <makyshplat@gmail.com>
 */
/**
 * Class Test_Giftwrapper_Helper_Data
 */
class Test_Giftwrapper_Helper_Data extends Mage_Core_Helper_Abstract
{
    CONST TEST_GIFT_WRAPPER_PRODUCT_PRICE = '5'; // this is a fake test price
    CONST TEST_GIFT_WRAPPER_PRODUCT_SKU = 'gift_wrapper_sku';
    CONST TEST_GIFT_WRAPPER_PRODUCT_GROUP = 'Gift Wrapper Settings';
    CONST TEST_GIFT_WRAPPER_MODULE_STATUS = 'test_giftwrapper/test_group/is_active';

    /**
     * @param $quoteItemId
     * @param $itemCollection
     * @return null
     */
    public function getParentQuoteItemSkuById($quoteItemId,$itemCollection)
    {
        $itemCollection->addFieldToFilter('item_id',['eq'=>$quoteItemId]);
        if($itemCollection->getSize()) {
            return $itemCollection->getFirstItem()->getSku();
        }

        return null;
    }

    /**
     * @param $parentItem
     * @return null
     */
    public function getCurrentItemFromParent($parentItem)
    {
        $itemCollection = Mage::getModel('sales/quote_item')->getCollection()
            ->setQuote($parentItem->getQuote())
            ->addFieldToFilter('gift_parent_item_id',['eq'=>$parentItem->getId()]);

        if($itemCollection->getSize()) {
            return $itemCollection->getFirstItem()->getId();
        }

        return null;
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function isEnabledModule($store = null)
    {
        if(!$store) {
            $store = Mage::app()->getStore();
        }

        return Mage::getStoreConfig(self::TEST_GIFT_WRAPPER_MODULE_STATUS, $store);
    }
}