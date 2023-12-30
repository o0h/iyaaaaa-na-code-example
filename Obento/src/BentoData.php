<?php

declare(strict_types=1);

namespace O0h\Obento;

readonly class BentoData
{
    public function __construct(public int $id, public string $name, public int $basePrice, public bool $saleFlag, public string $type, public bool $reservationOnly) {}
}
