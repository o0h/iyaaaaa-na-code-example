<?php

declare(strict_types=1);

namespace O0h\Obento\DiscountRule;

use O0h\Obento\BentoDB;

class VipWari implements DiscountRuleInterface
{
    #[\Override]
    public function calculate(BentoDB $db, int $productId, string $productType, bool $saleFlag, array $customizationIds, int $quantity, bool $isVipCustomer, bool $isPreOrder, $totalPrice): float|int
    {
        return $isVipCustomer ? (-1 * $totalPrice * 0.05) : 0;
    }
}
