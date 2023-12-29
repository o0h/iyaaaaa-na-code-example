<?php

declare(strict_types=1);

namespace O0h\Obento\Tests;

function setTestDb($testDbPath): void
{
    file_exists($testDbPath) && unlink($testDbPath);
    $pdo = new \PDO('sqlite:' . DB_PATH);
    foreach (glob(PJ_ROOT . '/schema/**.sql') as $source) {
        $sql = file_get_contents($source);
        $pdo->exec($sql);
    }
    unset($pdo);
}
