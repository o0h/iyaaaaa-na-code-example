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
        $paymentMethod,
        $pickupTime,
        $isPreOrder,
    ): void {
        $this->db->addOrder(
            $productId,
            $quantity,
            $customizationIds,
            $totalPrice,
            $paymentMethod,
            $pickupTime,
            $isPreOrder ? 1 : 0
        );
    }
}
