<?php
/**
 * Created by PhpStorm.
 * User: ${Gianluca}
 * Date: 15/04/15
 * Time: 7.32
 * To change this template use File | Settings | File Templates.
 */ 
class Zeta_Weightlimiter_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * Return the calculated weight for the current quote
     * @return float|int
     */
    public function getQuoteWeight()  {

        $quoteWeight = 0;

        /** @var $quoteItem Mage_Sales_Model_Quote_Item */
        foreach(Mage::getSingleton('checkout/cart')->getQuote()->getAllItems() as $quoteItem)    {

            $quoteWeight += $quoteItem->getWeight() * $quoteItem->getQty();

        }

        return $quoteWeight;

    }

}