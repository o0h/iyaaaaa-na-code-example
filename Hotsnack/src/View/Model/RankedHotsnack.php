<?php

declare(strict_types=1);

namespace O0h\IyaaaaaNaCodeExample\View\Model;

final readonly class RankedHotsnack
{
    public function __construct(
        public string $name,
        public string $description,
        public int $voted_count,
    ) {}
}
