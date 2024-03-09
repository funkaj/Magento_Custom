<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Local\TierPricing\Plugin;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Magento\Customer\Api\GroupManagementInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Pricing\Adjustment\CalculatorInterface;
use Magento\Framework\Pricing\Amount\AmountInterface;
use Magento\Framework\Pricing\Price\AbstractPrice;
use Magento\Framework\Pricing\Price\BasePriceProviderInterface;
use Magento\Framework\Pricing\PriceInfoInterface;
use Magento\Customer\Model\Group\RetrieverInterface as CustomerGroupRetrieverInterface;
/**
 * @api
 * @since 100.0.2
 */
class TierPrice
{
	 /**
     * Calculates savings percentage according to the given tier price amount
     * and related product price amount.
     *
     * @param AmountInterface $amount
     *
     * @return float
     */
    public function aroundGetSavePercent(\Magento\Catalog\Pricing\Price\TierPrice $subject,  \Closure $proceed, $amount)
    {
		// Interrupt the getSavePercent Function in vendor\magento\module-catalog\Pricing\Price\TierPrice.php line 223
		// Use msrp to determine the percent savings
		$msrp = $subject->getProduct()->getMsrp();
		// Check if MSRP is greater than 0 
		// If not set $originalPrice to the final price
		// else set $originalPrice to msrp rounded
		if ($msrp <= 0) {
			$originalPrice = $subject->getProduct()->getPriceInfo()->getPrice('final_price')->getValue();
		} else {
			$originalPrice = round($msrp*100/100, 2);
		}
		// Calculate percent saved off MSRP
		$result = ceil(100 - ((100 / $originalPrice) * $amount->getValue()));

		return $result;

    }
}
