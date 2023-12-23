<?php

declare(strict_types=1);

namespace O0h\IyaaaaaNaCodeExample\Model;

final class User extends DB
{
    public function get($id)
    {
        $select = $this->newSelect();
        $select->cols([
            'id',
            'name',
            'email',
        ])
            ->from('user')
            ->where('id = :id')
        ;

        return $this->execute($select, ['id' => $id]);
    }
}
