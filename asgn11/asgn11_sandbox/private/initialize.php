<?php

declare(strict_types=1);

$root = dirname(__DIR__);
require_once $root . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($root);
$dotenv->load();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/db_credentials.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Salamander.php';

$pdo = Database::connect();
Salamander::set_database($pdo);
