<?php
// Every public page loads this shared setup before printing HTML. Keeping the
// setup here gives each page the same dependencies, session, and database connection.
// Sessions and redirects need to send HTTP headers, so this must run before output.
// __DIR__ is this file's directory; its parent is the application root.
$project_root = dirname(__DIR__);
$autoload = $project_root . '/vendor/autoload.php';
// Composer creates this file during composer install. Stop with a useful setup
// message if it is missing, rather than failing later when Dotenv is first used.
if (!is_file($autoload)) {
    http_response_code(500);
    exit('Composer dependencies missing. Run composer install from the project root.');
}
require_once $autoload;

// Composer's autoloader makes the installed Dotenv package available on demand.
// Dotenv then reads local configuration into $_ENV for Database::connect().
try {
    // .env belongs beside composer.json, not inside public/ or private/.
    Dotenv\Dotenv::createImmutable($project_root)->load();
} catch (Throwable $exception) {
    // Keep the technical exception in the server log and show a short setup message.
    error_log('Dotenv: ' . $exception->getMessage());
    http_response_code(500);
    exit('Could not load the project-root .env file. Check your setup.');
}

// Start or resume the browser's session so pages can read the stored member ID.
// Checking the status avoids attempting to start an already-active session.
if (session_status() !== PHP_SESSION_ACTIVE) {
    // Strict mode rejects uninitialized IDs; HttpOnly prevents JavaScript from
    // reading the cookie. SameSite=Lax limits sending it on cross-site requests.
    ini_set('session.use_strict_mode', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

// Our course classes are loaded explicitly; Composer loads third-party packages.
// require_once prevents duplicate class/function declarations if setup is included again.
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Bird.php';
require_once __DIR__ . '/classes/Member.php';
require_once __DIR__ . '/functions.php';

try {
    // Open one PDO connection and give that same object to both Active Record
    // classes. Their methods can reuse it instead of opening a connection per query.
    $pdo = Database::connect();
    Bird::set_database($pdo);
    Member::set_database($pdo);
} catch (Throwable $exception) {
    // Without a database connection the application cannot continue this request.
    error_log('Database connection: ' . $exception->getMessage());
    http_response_code(500);
    exit('Could not connect to MySQL. Check .env and your local server.');
}
