<?php
/**
 * database.php
 * Singleton PDO database connection class.
 * Include this file wherever a DB connection is needed:
 *   require 'database.php';
 *   $pdo = Database::connect();
 *   Database::disconnect();
 */

// Load credentials from config.php (never committed to Git)
require_once __DIR__ . '/config.php';

class Database
{
    // Values are defined as constants in config.php
    private static string $dbHost     = DB_HOST;
    private static string $dbName     = DB_NAME;
    private static string $dbUser     = DB_USER;
    private static string $dbPassword = DB_PASS;

    private static ?PDO $connection = null;

    /** Prevent instantiation. */
    public function __construct()
    {
        die('Direct instantiation is not allowed. Use Database::connect().');
    }

    /**
     * Returns the shared PDO connection, creating it on first call.
     */
    public static function connect(): PDO
    {
        if (self::$connection === null) {
            try {
                $dsn = 'mysql:host=' . self::$dbHost . ';dbname=' . self::$dbName;
                self::$connection = new PDO($dsn, self::$dbUser, self::$dbPassword);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }

    /**
     * Closes the shared PDO connection.
     */
    public static function disconnect(): void
    {
        self::$connection = null;
    }
}
