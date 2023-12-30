<?php

declare(strict_types=1);

namespace O0h\Obento;

class BentoOrder
{
    private $db;
    private $productId; // 商品ID
    private $quantity;
    private $customizationIds;
    private $isPreOrder;
    private $needsChopsticks;
    private $pickupTime;
    private $paymentMethod;

    private BentoOrderPriceCalculator $calculator;
    private BentoOrderValidator $validator;

    public function __construct($productId, $productType, $quantity, $customizationIds, $basePrice, BentoDB $db, $isVipCustomer = false, $isPreOrder = false, $needsChopsticks = false, $pickupTime = null, $paymentMethod = 'cash')
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->customizationIds = $customizationIds;
        $this->db = $db;
        $this->isPreOrder = $isPreOrder;
        $this->needsChopsticks = $needsChopsticks;
        $this->pickupTime = $pickupTime;
        $this->paymentMethod = $paymentMethod;

        $this->customizationIds = $this->filterAcceptableCustomizationIds($productId, $customizationIds);

        $this->validator = new BentoOrderValidator($productId, $quantity, $isPreOrder, $db);

        $this->calculator = new BentoOrderPriceCalculator(
            $this->productId,
            $productType,
            $this->quantity,
            $this->customizationIds,
            $basePrice,
            $this->db,
            $isVipCustomer,
            $this->isPreOrder,
        );
    }

    public function isOrderAcceptable()
    {
        return $this->validator->isAcceptable();
    }

    public function registerOrder(): void
    {
        if ($this->isOrderAcceptable()) {
            $totalPrice = $this->calculator->calculateTotalPrice();
            $this->db->addOrder(
                $this->productId,
                $this->quantity,
                $this->customizationIds,
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
        return $this->calculator->getBasePrice();
    }

    public function isVoucherApplicable()
    {
        return $this->calculator->isVoucherApplicable();
    }

    public function applyVoucher(): void
    {
        $this->calculator->applyVoucher();
    }

    private function filterAcceptableCustomizationIds($productId, $customizationIds)
    {
        foreach ($customizationIds as $i => $customizationId) {
            if (!$this->db->isValidCustomization($productId, $customizationId)) {
                unset($customizationIds[$i]);
            }
        }

        return array_values($customizationIds);
    }
}
