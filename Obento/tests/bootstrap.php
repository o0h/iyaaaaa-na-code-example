<?php

declare(strict_types=1);

define('PJ_ROOT', dirname(__FILE__, 2));

require_once PJ_ROOT . '/vendor/autoload.php';

$testDbPath = PJ_ROOT . '/storage/test_db.sqlite';
define('DB_PATH', $testDbPath);

require_once __DIR__ . '/helper.php';
