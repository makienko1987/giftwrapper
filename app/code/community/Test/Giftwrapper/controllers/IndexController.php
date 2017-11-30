<?php
/**
 * @author      Andrey Makienko <makyshplat@gmail.com>
 */
/**
 * Class Test_Giftwrapper_IndexController
 */
class Test_Giftwrapper_IndexController extends Mage_Core_Controller_Front_Action
{

    public function ajaxAction()
    {
        $post = $this->getRequest()->getPost();

        if ($post) {
            $response = [];
            $response['error'] = false;
            /**
             * validation part
             */
            $error = false;

            try {
                if (!Zend_Validate::is(trim($post['product_id']), 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['parent_item_id']), 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post['action_item']), 'NotEmpty')) {
                    $error = true;
                }

                if ($error) {

                    throw new Exception($this->__('SKU of parent item is not valid'));
                }
                /** @var Mage_Checkout_Model_Cart $cart */
                $cart = Mage::getSingleton('checkout/cart');
                if($post['action_item'] == 'add') {
                    $skuParent = Mage::helper('test_giftwrapper')->getParentQuoteItemSkuById($post['parent_item_id'], $cart->getItems());
                    if (!$skuParent) {

                        throw new Exception($this->__('SKU of parent item is not valid'));
                    }
                    $product = $this->_initProduct($post['product_id'], $skuParent);

                    if(!$product) {

                        throw new Exception($this->__('Product is not valid'));
                    }
                    $cartRequest = array(
                        'product' => $product->getId(),
                        'qty' => '1'
                    );
                    $product->setData('gift_parent_item_id',$post['parent_item_id']);
                    $cart->addProduct($product, $cartRequest);
                    $cart->save();
                    $response['message'] = $this->__('Gift Wrapper Item has added successfully');
                } else {
                    $cart->removeItem($post['item_id']);
                    $cart->save();
                    $response['message'] = $this->__('Gift Wrapper Item was removed successfully');
                }

                Mage::getSingleton('checkout/session')->setCartWasUpdated(true);

            } catch (Exception $e) {
                $response['error'] = true;
                $response['message'] = $e->getMessage();
                $this->getResponse()->setHttpResponseCode(400);
            }

            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        }
    }

    /**
     * @param $productId
     * @param $parentSku
     * @return bool
     */
    protected function _initProduct($productId, $parentSku)
    {
        if ($productId) {
            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productId);
            if ($product->getId()) {
                $options = array();
                $options['parent_item_data'] = array(
                    'label' => 'Parent Item Sku',
                    'value' => $parentSku
                );

                $product->addCustomOption('additional_options', serialize($options));
                return $product;
            }
        }

        return false;
    }
}