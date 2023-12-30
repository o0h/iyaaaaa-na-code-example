<?php

declare(strict_types=1);

namespace O0h\Obento;

use Cake\Chronos\Chronos;

class BentoOrderPriceCalculator
{
    private $db;
    private $productId; // 商品ID
    private $quantity;
    private $customizationIds;
    private $isVipCustomer;
    private $isPreOrder;
    private $productType;

    private bool $voucherApplied = false;
    private $basePrice;

    public function __construct($productId, $productType, $quantity, $customizationIds, $basePrice, BentoDB $db, $isVipCustomer = false, $isPreOrder = false)
    {
        $this->productId = $productId;
        $this->productType = $productType;
        $this->quantity = $quantity;
        $this->customizationIds = $customizationIds;
        $this->db = $db;
        $this->isVipCustomer = $isVipCustomer;
        $this->isPreOrder = $isPreOrder;
        $this->basePrice = $basePrice;
    }

    public function calculateTotalPrice()
    {
        $productInfo = $this->db->getProductInfo($this->productId);
        $productType = $productInfo['product_type'];
        $basePrice = $this->getBasePrice();

        $totalPrice = $basePrice * $this->quantity;
        $hasTea = false;

        foreach ($this->customizationIds as $i => $customizationId) {
            if (BentoDB::BENTO_KARAAGE_TOKUDAI_ID === $this->productId && BentoDB::CUSTOMIZE_GOHAN_OOMORI_ID === $customizationId) {
                continue;
            }
            if ($productType === 'bento' && $customizationId === BentoDB::CUSTOMIZE_OCHA_ID) {
                $hasTea = true;
            }
            $customizationPrice = $this->db->getCustomizationPrice($customizationId);
            $totalPrice += $customizationPrice * $this->quantity;
        }
        if ($this->isVipCustomer) {
            $totalPrice *= 0.95;
        }
        if ($this->quantity >= 5 && 'bento' === $this->productType) {
            $totalPrice -= 300;
        }
        if ($productInfo['sale_flag'] && !$this->isPreOrder && $this->isTimeSale()) {
            $totalPrice -= 120;
        }

        if ($hasTea) {
            $totalPrice -= 50;
        }

        return (int)ceil($totalPrice);
    }

    public function getBasePrice()
    {
        return $this->basePrice;
    }

    public function isVoucherApplicable()
    {
        $productInfo = $this->db->getProductInfo($this->productId);
        $basePrice = $productInfo['price'];

        return $basePrice <= 800 && 'bento' === $this->productType && !$this->isTimeSale();
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
