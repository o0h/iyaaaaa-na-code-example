<?php

declare(strict_types=1);

namespace O0h\IyaaaaaNaCodeExample\Model;

final class Hotsnack extends DB
{
    public function getAll(): void
    {
        $select = $this->newSelect();
        $query = $select
            ->from('hotsnack')
            ->cols(['id', 'name', 'description'])
        ;
        $result = $this->execute($query);
        $rows = $result->fetchAll();
        var_dump($rows);
    }
}
