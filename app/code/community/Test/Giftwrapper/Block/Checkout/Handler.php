<?php
/**
 * @author      Andrey Makienko <makyshplat@gmail.com>
 */
/**
 * Class Test_Giftwrapper_Block_Checkout_Handler
 */
class Test_Giftwrapper_Block_Checkout_Handler extends Mage_Core_Block_Template
{
    protected $_template = 'checkout/cart/test_giftwrapper/handler.phtml';
    /**
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl('test_giftwrapper/index/ajax',['form_key' => Mage::getSingleton('core/session')->getFormKey()]);
    }

    /**
     * @return mixed
     */
    public function isModuleEnabled()
    {
        return Mage::helper('test_giftwrapper')->isEnabledModule(Mage::app()->getStore()->getId());
    }
}