<?php

declare(strict_types=1);

namespace O0h\Obento;

class BentoOrder
{
    public static function create(
        $productId,
        $quantity,
        $customizationIds,
        BentoDB $db,
        $isVipCustomer = false,
        $isPreOrder = false,
        $needsChopsticks = false,
        $pickupTime = null,
        $paymentMethod = 'cash'
    ): self {
        $bentoData = $db->getProductInfo($productId);
        $orderContext = new BentoOrderContextData(
            $isVipCustomer,
            $isPreOrder,
            $needsChopsticks,
            $pickupTime,
            $paymentMethod,
        );
        $customizationFilter = new CustomizationFilter($db);
        $customizationIds = $customizationFilter->onlyValid($bentoData->id, $customizationIds);

        $validator = new BentoOrderValidator($productId, $quantity, $orderContext->isPreOrder, $db);

        $calculator = new BentoOrderPriceCalculator(
            $bentoData,
            $quantity,
            $customizationIds,
            $orderContext,
            $db,
        );
        $register = new BentoOrderRegister($db);

        return new self($bentoData, $quantity, $customizationIds, $orderContext, $calculator, $validator, $register);
    }

    private function __construct(
        private readonly BentoData $bentoData,
        private readonly int $quantity,
        private readonly array $customizationIds,
        private readonly BentoOrderContextData $orderContext,
        private readonly BentoOrderPriceCalculator $calculator,
        private readonly BentoOrderValidator $validator,
        private readonly BentoOrderRegister $register,
    ) {}

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
