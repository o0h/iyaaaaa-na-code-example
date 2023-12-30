<?php

declare(strict_types=1);

namespace O0h\Obento\DiscountRule;

use O0h\Obento\BentoDB;

class KaraageTokudaiOomoriMuryo implements DiscountRuleInterface
{
    #[\Override]
    public function calculate(BentoDB $db, int $productId, string $productType, bool $saleFlag, array $customizationIds, int $quantity, bool $isVipCustomer, bool $isPreOrder, $totalPrice): int
    {
        if ($productId !== BentoDB::BENTO_KARAAGE_TOKUDAI_ID) {
            return 0;
        }
        if (!\in_array(BentoDB::CUSTOMIZE_GOHAN_OOMORI_ID, $customizationIds, true)) {
            return 0;
        }

        $oomoriPrice = $db->getCustomizationPrice(BentoDB::CUSTOMIZE_GOHAN_OOMORI_ID);

        return $oomoriPrice * $quantity;
    }
}
