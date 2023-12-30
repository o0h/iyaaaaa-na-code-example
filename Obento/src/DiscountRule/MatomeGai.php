<?php

declare(strict_types=1);

namespace O0h\Obento\DiscountRule;

use O0h\Obento\BentoDB;

class MatomeGai implements DiscountRuleInterface
{
    #[\Override]
    public function calculate(BentoDB $db, int $productId, string $productType, bool $saleFlag, array $customizationIds, int $quantity, bool $isVipCustomer, bool $isPreOrder, $totalPrice): float|int
    {
        return ($quantity >= 5 && $productType === 'bento') ? -300 : 0;
    }
}
