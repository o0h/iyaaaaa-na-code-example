<?php

declare(strict_types=1);

namespace O0h\Obento;

use Cake\Chronos\Chronos;

class BentoOrderPriceCalculator
{
    private $db;
    private $quantity;
    private $customizationIds;
    private $isVipCustomer;
    private $isPreOrder;

    private bool $voucherApplied = false;

    public function __construct(private BentoData $bento, $quantity, $customizationIds, BentoDB $db, $isVipCustomer = false, $isPreOrder = false)
    {
        $this->quantity = $quantity;
        $this->customizationIds = $customizationIds;
        $this->db = $db;
        $this->isVipCustomer = $isVipCustomer;
        $this->isPreOrder = $isPreOrder;
    }

    public function calculateTotalPrice()
    {
        $totalPrice = $this->bento->basePrice * $this->quantity;
        $hasTea = false;

        foreach ($this->customizationIds as $i => $customizationId) {
            if (BentoDB::BENTO_KARAAGE_TOKUDAI_ID === $this->bento->id && BentoDB::CUSTOMIZE_GOHAN_OOMORI_ID === $customizationId) {
                continue;
            }
            if ($this->bento->type === 'bento' && $customizationId === BentoDB::CUSTOMIZE_OCHA_ID) {
                $hasTea = true;
            }
            $customizationPrice = $this->db->getCustomizationPrice($customizationId);
            $totalPrice += $customizationPrice * $this->quantity;
        }
        if ($this->isVipCustomer) {
            $totalPrice *= 0.95;
        }
        if ($this->quantity >= 5 && 'bento' === $this->bento->type) {
            $totalPrice -= 300;
        }
        if ($this->bento->saleFlag && !$this->isPreOrder && $this->isTimeSale()) {
            $totalPrice -= 120;
        }

        if ($hasTea) {
            $totalPrice -= 50;
        }

        if ($this->voucherApplied) {
            $totalPrice -= $this->getBasePrice();
        }

        return (int)ceil($totalPrice);
    }

    public function getBasePrice()
    {
        return $this->bento->basePrice;
    }

    public function isVoucherApplicable()
    {
        return $this->bento->basePrice <= 800 && 'bento' === $this->bento->type && !$this->isTimeSale();
    }

    public function applyVoucher(): void
    {
        if ($this->isVoucherApplicable()) {
            $this->voucherApplied = true;
        }
    }

    private function isTimeSale()
    {
        $now = Chronos::now();
        $currentHour = $now->format('H');
        $currentWeekDay = $now->format('N');

        return ($currentHour >= 14 && $currentHour <= 16) && ($currentWeekDay >= 1 && $currentWeekDay <= 5);
    }
}
