<?php
/**
 * @author      Andrey Makienko <makyshplat@gmail.com>
 */
/**
 * Class Test_Giftwrapper_Model_Observer
 */
class Test_Giftwrapper_Model_Observer
{
    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function updateQuoteItems(Varien_Event_Observer $observer)
    {
        $quoteItem = $observer->getEvent()->getQuoteItem();
        $product = $observer->getEvent()->getProduct();
        if ($product->getIsGiftwrapperProduct() && Mage::helper('test_giftwrapper')->isEnabledModule($quoteItem->getStoreId())) {
            if ($product->getData('gift_parent_item_id')) {
                $quoteItem->setData('gift_parent_item_id', $product->getData('gift_parent_item_id'));
            }
        }

        return $this;
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function salesConvertQuoteItemToOrderItem(Varien_Event_Observer $observer)
    {
        $quoteItem = $observer->getItem();
        if (Mage::helper('test_giftwrapper')->isEnabledModule($quoteItem->getStoreId()) &&
            ($additionalOptions = $quoteItem->getOptionByCode('additional_options')))
        {
            $orderItem = $observer->getOrderItem();
            $options = $orderItem->getProductOptions();
            $options['additional_options'] = unserialize($additionalOptions->getValue());
            $orderItem->setProductOptions($options);
        }

        return $this;
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function updateGiftWrapperAfterRemovingParent(Varien_Event_Observer $observer)
    {
        $quoteItem = $observer->getEvent()->getQuoteItem();
        if (Mage::helper('test_giftwrapper')->isEnabledModule($quoteItem->getStoreId())) {
            $giftWrapperItemId = Mage::helper('test_giftwrapper')->getCurrentItemFromParent($quoteItem);
            if($giftWrapperItemId) {
                $quoteItem->getQuote()->removeItem($giftWrapperItemId);
            }
        }

        return $this;
    }
}
