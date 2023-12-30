<?php

declare(strict_types=1);

namespace O0h\Obento;

use O0h\Obento\DiscountRule\DiscountRuleInterface;
use O0h\Obento\DiscountRule\KaraageTokudaiOomoriMuryo;
use O0h\Obento\DiscountRule\MatomeGai;
use O0h\Obento\DiscountRule\OchaWari;
use O0h\Obento\DiscountRule\TimeSale;
use O0h\Obento\DiscountRule\VipWari;

class DiscountCalculator
{
    /** @var array<DiscountRuleInterface> */
    private array $rules = [
        VipWari::class,
        KaraageTokudaiOomoriMuryo::class,
        MatomeGai::class,
        TimeSale::class,
        OchaWari::class,
    ];

    public function __construct(
        private BentoDB $db,
        private $productId,
        private string $productType,
        private bool $saleFlag,
        private array $customizationIds,
        private int $quantity,
        private bool $isVipCustomer,
        private bool $isPreOrder,
        private int $totalPrice,
    ) {}

    public function apply(): int
    {
        $totalPrice = $this->totalPrice;
        foreach ($this->rules as $rule) {
            $calculator = new $rule();
            $totalPrice += $calculator->calculate(
                $this->db,
                $this->productId,
                $this->productType,
                $this->saleFlag,
                $this->customizationIds,
                $this->quantity,
                $this->isVipCustomer,
                $this->isPreOrder,
                $totalPrice,
            );
        }

        return (int)ceil($totalPrice);
    }
}
