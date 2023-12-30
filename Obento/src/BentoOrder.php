<?php

declare(strict_types=1);

namespace O0h\Obento;

use Cake\Chronos\Chronos;

class BentoOrder
{
    private $db;
    private $productId; // 商品ID
    private $quantity;
    private $customizationIds;
    private $isVipCustomer;
    private $isPreOrder;
    private $needsChopsticks;
    private $pickupTime;
    private $paymentMethod;
    private $productType;

    private bool $voucherApplied = false;
    private $basePrice;
    private BentoOrderPriceCalculator $calculator;

    public function __construct($productId, $productType, $quantity, $customizationIds, $basePrice, BentoDB $db, $isVipCustomer = false, $isPreOrder = false, $needsChopsticks = false, $pickupTime = null, $paymentMethod = 'cash')
    {
        $this->productId = $productId;
        $this->productType = $productType;
        $this->quantity = $quantity;
        $this->customizationIds = $customizationIds;
        $this->db = $db;
        $this->isVipCustomer = $isVipCustomer;
        $this->isPreOrder = $isPreOrder;
        $this->needsChopsticks = $needsChopsticks;
        $this->pickupTime = $pickupTime;
        $this->paymentMethod = $paymentMethod;
        $this->basePrice = $basePrice;

        foreach ($this->customizationIds as $i => $customizationId) {
            if (!$this->db->isValidCustomization($this->productId, $customizationId)) {
                unset($this->customizationIds[$i]);
            }
        }
        $this->calculator = new BentoOrderPriceCalculator(
            $this->productId,
            $this->productType,
            $this->quantity,
            $this->customizationIds,
            $this->basePrice,
            $this->db,
            $this->isVipCustomer,
            $this->isPreOrder,
        );
    }

    public function isOrderAcceptable()
    {
        if ($this->db->isReservationOnly($this->productId) && !$this->isPreOrder) {
            return false;
        }
        $stockData = $this->db->getStock($this->productId);
        $currentStock = $stockData['stock'] ?? 0;
        $reservedStock = $stockData['reserved_stock'] ?? 0;

        return $currentStock - $reservedStock >= $this->quantity;
    }

    public function registerOrder(): void
    {
        if ($this->isOrderAcceptable()) {
            $totalPrice = $this->calculator->calculateTotalPrice();
            if ($this->voucherApplied) {
                $totalPrice -= $this->getBasePrice();
            }
            $this->db->addOrder(
                $this->productId,
                $this->quantity,
                array_values($this->customizationIds),
                $totalPrice,
                $this->paymentMethod,
                $this->pickupTime,
                $this->isPreOrder ? 1 : 0
            );
            $message = '注文が完了しました ID: ' . $this->productId . '、数量: ' . $this->quantity;
            if ($this->needsChopsticks) {
                $message .= '(割り箸が必要)';
            }
            $message .= '、合計金額: ' . $totalPrice . '円、支払い方法: ' . $this->paymentMethod;
            echo $message . "\n";
        } else {
            echo "申し訳ありません、在庫が不足しています。\n";
        }
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
