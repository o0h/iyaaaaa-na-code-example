<?php

declare(strict_types=1);

namespace O0h\IyaaaaaNaCodeExample\Model;

use Aura\SqlQuery\QueryFactory;
use Aura\SqlQuery\QueryInterface;

abstract class DB
{
    private \PDO $dba;
    private QueryFactory $queryFactory;

    public function __construct(?\PDO $dba = null)
    {
        if (!$dba) {
            $dba = new \PDO('sqlite:' . PJ_ROOT . '/storage/app_db.sqlite');
        }
        $this->dba = $dba;
        $this->queryFactory = new QueryFactory('sqlite');
    }

    public function newSelect()
    {
        return $this->queryFactory->newSelect();
    }

    protected function execute(QueryInterface $query, array $values = null): \PDOStatement
    {
        if ($values) {
            $query->bindValues($values);
        }
        $stmt = $this->dba->prepare($query->getStatement());
        $stmt->execute($query->getBindValues());

        return $stmt;
    }
}
