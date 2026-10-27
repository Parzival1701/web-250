<?php

// __DIR__ is this file's directory, independent of the working directory.
// Load files explicitly. Autoloading and callbacks are not used in asgn08.
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/db_credentials.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Bird.php';
$pdo = Database::connect();
Bird::set_database($pdo);

// try {
//     $pdo = (isset($pdo) && $pdo instanceof PDO) ? $pdo : Database::connect();
//     Bird::set_database($pdo);
//     $birds = Bird::find_all();
// } catch (PDOException $e) {
//     error_log($e->getMessage());
//     http_response_code(500);
//     exit('Could not load the bird sandbox. Check the database connection.');
// }



// Do not connect here. index.php connects inside its try/catch block.
