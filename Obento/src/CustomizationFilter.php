<?php

declare(strict_types=1);

namespace O0h\Obento;

class CustomizationFilter
{
    public function __construct(private BentoDB $db) {}

    public function onlyValid($productId, array $customizationIds): array
    {
        foreach ($customizationIds as $i => $customizationId) {
            if (!$this->db->isValidCustomization($productId, $customizationId)) {
                unset($customizationIds[$i]);
            }
        }

        return array_values($customizationIds);
    }
}
