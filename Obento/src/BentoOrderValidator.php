<?php

declare(strict_types=1);

namespace O0h\Obento;

class BentoOrderValidator
{
    public function __construct(private $productId, private int $quantity, private bool $isPreOrder, private BentoDB $db) {}

    public function isAcceptable()
    {
        if ($this->db->isReservationOnly($this->productId) && !$this->isPreOrder) {
            return false;
        }
        $stockData = $this->db->getStock($this->productId);
        $currentStock = $stockData['stock'] ?? 0;
        $reservedStock = $stockData['reserved_stock'] ?? 0;

        return $currentStock - $reservedStock >= $this->quantity;
    }
}
