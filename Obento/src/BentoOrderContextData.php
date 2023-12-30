<?php

declare(strict_types=1);

namespace O0h\Obento;

readonly class BentoOrderContextData
{
    public function __construct(
        public readonly bool $isVipCustomer = false,
        public readonly bool $isPreOrder = false,
        public readonly bool $needsChopsticks = false,
        public readonly ?int $pickupTime = null,
        public readonly string $paymentMethod = 'cash'
    ) {}
}
