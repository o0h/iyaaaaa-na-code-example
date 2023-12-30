<?php

declare(strict_types=1);

namespace O0h\Obento\DiscountRule;

use O0h\Obento\BentoDB;
use O0h\Obento\BentoOrder;

class TimeSale implements DiscountRuleInterface
{
    #[\Override]
    public function calculate(BentoDB $db, int $productId, string $productType, bool $saleFlag, array $customizationIds, int $quantity, bool $isVipCustomer, bool $isPreOrder, $totalPrice): float|int
    {
        return ($saleFlag && !$isPreOrder && BentoOrder::isTimeSale()) ? -120 : 0;
    }
}
