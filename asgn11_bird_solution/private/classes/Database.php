<?php
// Open the database connection here; Bird and Member contain their own SQL.
class Database
{
    public static function connect(): PDO
    {
        // initialize.php calls this method, then gives the same PDO object to both classes.
        // Dotenv fills $_ENV; ?? supplies a default when a setting is missing.
        $host = (string) ($_ENV['DB_HOST'] ?? '127.0.0.1');
        $port = (string) ($_ENV['DB_PORT'] ?? '3306');
        $name = (string) ($_ENV['DB_NAME'] ?? 'wnc_birds');
        $user = (string) ($_ENV['DB_USER'] ?? '');
        $pass = (string) ($_ENV['DB_PASS'] ?? '');

        // A port must contain digits before we place it in the connection string.
        if (!ctype_digit($port)) {
            throw new RuntimeException('Invalid DB_PORT value in .env.');
        }
        // The DSN identifies the driver, server, and database. utf8mb4 supports Unicode text.
        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
        return new PDO($dsn, $user, $pass, [
            // Exceptions let the calling code catch a failed connection or query.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Rows normally use column names as keys, such as $row['first_name'].
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Ask MySQL to prepare statements instead of having PDO imitate that step.
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
