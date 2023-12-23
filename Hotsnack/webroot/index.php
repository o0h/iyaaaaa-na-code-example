<?php
require dirname(__FILE__, 2) . '/vendor/autoload.php';
require dirname(__FILE__, 2) . '/bootstrap.php';
require dirname(__FILE__, 2) . '/routes.php';

$route = $_GET['page'] ?? 'ranking';
dispatch($route);