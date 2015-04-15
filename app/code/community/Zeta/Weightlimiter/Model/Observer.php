<?php

class Zeta_Weightlimiter_Model_Observer {

    const XML_PATH_MODULE_ENABLED = 'config_weight/minimum_weight/enabled';
    const XML_PATH_MINIMUM_WEIGHT = 'config_weight/minimum_weight/weight';

    public function addMessage(Varien_Event_Observer $observer)  {

        /** @var $block Mage_Core_Block_Abstract*/
        $block = $observer->getEvent()->getBlock();

        /** @var $session Mage_Checkout_Model_Session*/
        $session = Mage::getSingleton('checkout/session');

        if(Mage::app()->getRequest()->getModuleName() == 'checkout'
            && Mage::app()->getRequest()->getActionName('index')
            && Mage::getStoreConfig(self::XML_PATH_MODULE_ENABLED))   {

            /** Return if has no items */
            if(!Mage::getSingleton('checkout/cart')->getQuote()->hasItems())    {
                return $this;
            }

            $_quoteWeight = Mage::helper('zeta_weightlimiter')->getQuoteWeight();

            if($block->getNameInLayout() == 'root' && $_quoteWeight < Mage::getStoreConfig(self::XML_PATH_MINIMUM_WEIGHT)) {

                $session->addError(Mage::helper('zeta_weightlimiter')->__('Total weight is %s kg. You must buy at least %s kg in order to checkout.', $_quoteWeight, Mage::getStoreConfig(self::XML_PATH_MINIMUM_WEIGHT)));

            }


        }

        return $this;
    }

    public function disableOnepageLink(Varien_Event_Observer $observer)    {

        if(Mage::app()->getRequest()->getModuleName() == 'checkout'
            && Mage::app()->getRequest()->getActionName('index')
            && Mage::getStoreConfig(self::XML_PATH_MODULE_ENABLED))   {

            /** @var $block Mage_Core_Block_Abstract*/
            $block = $observer->getEvent()->getBlock();

            $_quoteWeight = Mage::helper('zeta_weightlimiter')->getQuoteWeight();

            if($block->getNameInLayout() == 'checkout.cart.methods.onepage' && $_quoteWeight < Mage::getStoreConfig(self::XML_PATH_MINIMUM_WEIGHT)) {

                $block->setTemplate('');

            }

        }




    }

}