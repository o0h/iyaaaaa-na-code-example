<?php

declare(strict_types=1);

namespace O0h\Obento\DiscountRule;

use O0h\Obento\BentoDB;

class OchaWari implements DiscountRuleInterface
{
    #[\Override]
    public function calculate(BentoDB $db, int $productId, string $productType, bool $saleFlag, array $customizationIds, int $quantity, bool $isVipCustomer, bool $isPreOrder, $totalPrice): float|int
    {
        if ($productType !== 'bento') {
            return 0;
        }

        return \in_array(BentoDB::CUSTOMIZE_OCHA_ID, $customizationIds, true) ? -50 : 0;
    }
}
