<?php
/**
 * @author      Andrey Makienko <makyshplat@gmail.com>
 */
/**
 * Class Test_Giftwrapper_Block_Checkout_Item
 */
class Test_Giftwrapper_Block_Checkout_Item extends Mage_Core_Block_Template
{
    /**
     * @var string
     */
    protected $_template = 'checkout/cart/test_giftwrapper/checkbox.phtml';

    /**
     *
     */
    protected function _construct()
    {
        parent::_construct();
    }

    /**
     * @return null
     */
    public function getGiftWrapperProductId()
    {
        $productWrapperCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter('is_giftwrapper_product', ['eq' => true]);
        if ($productWrapperCollection->getSize()) {
            return $productWrapperCollection->getFirstItem()->getId();
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function isModuleEnabled()
    {
        return Mage::helper('test_giftwrapper')->isEnabledModule(Mage::app()->getStore()->getId());
    }
}