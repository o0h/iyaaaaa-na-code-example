<?php

declare(strict_types=1);

namespace O0h\Obento;

class BentoOrderManager
{
    private $orders = [];

    public function addOrder($order): void
    {
        $this->orders[] = $order;
    }

    public function finalizeOrders(bool $usingVoucher = false): void
    {
        if ($usingVoucher) {
            $this->useVoucher();
        }

        // 注文を保存する
        foreach ($this->orders as $order) {
            $order->registerOrder();
        }
    }

    private function useVoucher()
    {
        $toApplyVoucher = $this->getOrderToApplyVoucher();
        if (!$toApplyVoucher) {
            echo "引換券を利用する条件を満たす注文がありません。\n";
            return;
        }

        $toApplyVoucher->applyVoucher();
    }

    private function getOrderToApplyVoucher()
    {
        $candidate = null;

        // 引換券での引き換え対象のうち、最高価格の注文を選別する
        foreach ($this->orders as $order) {
            if (!$order->isVoucherApplicable()) {
                continue;
            }

            if ($order->getBasePrice() <= $candidate?->getBasePrice()) {
                continue;
            }

            $candidate = $order;
        }

        return $candidate;
    }
}
