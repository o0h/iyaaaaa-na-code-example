<?php

declare(strict_types=1);

namespace O0h\Obento;

class BentoOrderManager
{
    private $orders;
    private $usingVoucher;

    public function __construct($usingVoucher = false)
    {
        $this->orders = [];
        $this->usingVoucher = $usingVoucher;
    }

    public function addOrder($order): void
    {
        $this->orders[] = $order;
    }

    public function finalizeOrders(): void
    {
        if ($this->usingVoucher) {
            $maxPriceOrder = null;
            $maxPrice = 0;
            $voucherApplied = false;

            foreach ($this->orders as $order) {
                if ($order->isVoucherApplicable() && $order->getBasePrice() > $maxPrice) {
                    $maxPriceOrder = $order;
                    $maxPrice = $order->getBasePrice();
                }
            }

            if ($maxPriceOrder) {
                $maxPriceOrder->applyVoucher();
                $voucherApplied = true;
            }

            if ($this->usingVoucher && !$voucherApplied) {
                echo "引換券を利用する条件を満たす注文がありません。\n";
            }
        }
        foreach ($this->orders as $order) {
            $order->registerOrder();
        }
    }
}
