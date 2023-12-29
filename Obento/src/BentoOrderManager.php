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
        // 引換券を利用したい場合は
        if ($usingVoucher) {
            $toApplyVoucher = $this->getOrderToApplyVoucher();
            // 対象があれば、引換券を適用する
            if ($toApplyVoucher) {
                $toApplyVoucher->applyVoucher();
            } else { // 対象がなければエラーメッセージを出力する
                echo "引換券を利用する条件を満たす注文がありません。\n";
            }
        }

        // 注文を保存する
        foreach ($this->orders as $order) {
            $order->registerOrder();
        }
    }

    private function getOrderToApplyVoucher()
    {
        $toApplyVoucher = null;
        $maxPrice = 0;

        // 引換券での引き換え対象のうち、最高価格の注文を選別する
        foreach ($this->orders as $order) {
            if ($order->isVoucherApplicable() && $order->getBasePrice() > $maxPrice) {
                $toApplyVoucher = $order;
                $maxPrice = $order->getBasePrice();
            }
        }

        return $toApplyVoucher;
    }
}
