<?php

declare(strict_types=1);

namespace O0h\Obento\DiscountRule;

use O0h\Obento\BentoDB;

interface DiscountRuleInterface
{
    public function calculate(
        BentoDB $db,
        int $productId,
        string $productType,
        bool $saleFlag,
        array $customizationIds,
        int $quantity,
        bool $isVipCustomer,
        bool $isPreOrder,
        $totalPrice,
    ): float|int;
}
