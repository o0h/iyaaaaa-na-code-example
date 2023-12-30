<?php

declare(strict_types=1);

namespace O0h\Obento;

class BentoOrderRegister
{
    public function __construct(private BentoDB $db) {}

    public function register(
        $productId,
        $quantity,
        $customizationIds,
        $totalPrice,
        BentoOrderContextData $orderContext,
    ): void {
        $this->db->addOrder(
            $productId,
            $quantity,
            $customizationIds,
            $totalPrice,
            $orderContext->paymentMethod,
            $orderContext->pickupTime,
            $orderContext->isPreOrder ? 1 : 0
        );
    }
}
