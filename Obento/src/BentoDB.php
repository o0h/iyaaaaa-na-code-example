<?php

declare(strict_types=1);

namespace O0h\Obento;

class BentoDB
{
    private $dba;

    public const int BENTO_KARAAGE_TOKUDAI_ID = 4;
    public const int CUSTOMIZE_GOHAN_OOMORI_ID = 1;
    public const int CUSTOMIZE_OCHA_ID = 7;

    public function __construct()
    {
        \assert(\defined('\\DB_PATH'));
        $this->dba = new \PDO('sqlite:' . DB_PATH);
    }

    public function getStock($product)
    {
        $stmt = $this->dba->prepare('SELECT stock, reserved_stock FROM bento_products WHERE id = ?');
        $stmt->execute([$product]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ? $row : null;
    }

    public function updateReservedStock($product, $quantity): void
    {
        $stmt = $this->dba->prepare('UPDATE products SET reserved_stock = reserved_stock + ? WHERE name = ?');
        $stmt->execute([$quantity, $product]);
    }

    public function updateStockForPreOrder($product, $quantity): void
    {
        $stmt = $this->dba->prepare('UPDATE products SET stock = stock - ?, reserved_stock = reserved_stock - ? WHERE name = ?');
        $stmt->execute([$quantity, $quantity, $product]);
    }

    public function getCustomizationPrice($customizationId)
    {
        $stmt = $this->dba->prepare('SELECT additional_price FROM bento_customizations WHERE id = ?');
        $stmt->execute([$customizationId]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ? (int)$row['additional_price'] : 0;
    }

    public function isValidCustomization($bentoId, $customizationId)
    {
        $stmt = $this->dba->prepare('
            SELECT COUNT(*)
            FROM bento_customization_relations bcr
            JOIN bento_customizations bc ON bcr.customization_id = bc.id
            WHERE bcr.bento_id = ? AND bc.id = ?
        ');
        $stmt->execute([$bentoId, $customizationId]);

        return $stmt->fetchColumn() > 0;
    }

    public function getProductType($productName)
    {
        $stmt = $this->dba->prepare('SELECT product_type FROM bento_products WHERE name = ?');
        $stmt->execute([$productName]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ? $row['product_type'] : null;
    }

    public function isReservationOnly($product)
    {
        $stmt = $this->dba->prepare('SELECT reservation_only FROM bento_products WHERE id = ?');
        $stmt->execute([$product]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row && 1 === $row['reservation_only'];
    }

    public function addOrder($p, $q, $c, $pr, $pm, $pt, $ip): void
    {
        $this->dba->prepare('INSERT INTO orders (product_id, quantity, customizations, price, payment_method, pickup_time, order_date, is_pre_order) VALUES (?, ?, ?, ?, ?, ?, CURRENT_DATE, ?)')->execute([$p, $q, json_encode($c), $pr, $pm, $pt, $ip]);
    }

    public function getProductInfo($productId): ?BentoData
    {
        $stmt = $this->dba->prepare('SELECT * FROM bento_products WHERE id = ?');
        $stmt->execute([$productId]);

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        return new BentoData(
            $data['id'],
            $data['name'],
            $data['price'],
            (bool)$data['sale_flag'],
            $data['product_type'],
            (bool)$data['reservation_only'],
        );
    }
}
