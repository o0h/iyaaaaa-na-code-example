<?php

declare(strict_types=1);

namespace O0h\Obento;

class BentoOrder
{
    private $quantity;
    private $customizationIds;
    private readonly BentoData $bentoData;
    private readonly BentoOrderContextData $orderContext;
    private BentoOrderPriceCalculator $calculator;
    private BentoOrderValidator $validator;
    private BentoOrderRegister $register;

    public function __construct($productId, $quantity, $customizationIds, BentoDB $db, $isVipCustomer = false, $isPreOrder = false, $needsChopsticks = false, $pickupTime = null, $paymentMethod = 'cash')
    {
        $this->quantity = $quantity;
        $this->customizationIds = $customizationIds;

        $this->bentoData = $db->getProductInfo($productId);
        $this->orderContext = new BentoOrderContextData(
            $isVipCustomer,
            $isPreOrder,
            $needsChopsticks,
            $pickupTime,
            $paymentMethod,
        );
        $customizationFilter = new CustomizationFilter($db);
        $this->customizationIds = $customizationFilter->onlyValid($this->bentoData->id, $customizationIds);

        $this->validator = new BentoOrderValidator($productId, $quantity, $this->orderContext->isPreOrder, $db);

        $this->calculator = new BentoOrderPriceCalculator(
            $this->bentoData,
            $this->quantity,
            $this->customizationIds,
            $this->orderContext,
            $db,
        );
        $this->register = new BentoOrderRegister($db);
    }

    public function isOrderAcceptable()
    {
        return $this->validator->isAcceptable();
    }

    public function registerOrder(): void
    {
        if ($this->isOrderAcceptable()) {
            $totalPrice = $this->calculator->calculateTotalPrice();
            $this->register->register(
                $this->bentoData->id,
                $this->quantity,
                $this->customizationIds,
                $totalPrice,
                $this->orderContext,
            );
            $message = '注文が完了しました ID: ' . $this->bentoData->id . '、数量: ' . $this->quantity;
            if ($this->orderContext->needsChopsticks) {
                $message .= '(割り箸が必要)';
            }
            $message .= '、合計金額: ' . $totalPrice . '円、支払い方法: ' . $this->orderContext->paymentMethod;
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
}
