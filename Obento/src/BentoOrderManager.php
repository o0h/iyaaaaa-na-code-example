<?php

declare(strict_types=1);

namespace O0h\Obento;

class BentoOrderManager
{
    /** @var array<BentoOrder> */
    private array $orders = [];

    /**
     * 注文を追加する.
     *
     * @param BentoOrder $order
     */
    public function addOrder($order): void
    {
        $this->orders[] = $order;
    }

    /**
     * 複数の注文の金額を確定し、データを保存する.
     *
     * - 引換券を適用する
     * - 注文データを保存する
     *
     * @param bool $usingVoucher 引換券を利用するか
     */
    public function finalizeOrders(bool $usingVoucher = false): void
    {
        if ($usingVoucher) {
            $this->useVoucher();
        }

        foreach ($this->orders as $order) {
            $order->registerOrder();
        }
    }

    /**
     * 引換券の利用処理を行う.
     *
     * - 適用対象の注文を選定する
     * - 適用対象であることをマークする
     * - 適用できる注文が存在しなかった場合はエラーメッセージを出力する
     */
    private function useVoucher(): void
    {
        $toApplyVoucher = $this->getOrderToApplyVoucher();
        if (!$toApplyVoucher) {
            echo "引換券を利用する条件を満たす注文がありません。\n";

            return;
        }

        $toApplyVoucher->applyVoucher();
    }

    /**
     * 適用対象の注文を選定する.
     */
    private function getOrderToApplyVoucher(): ?BentoOrder
    {
        $candidate = null;

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
