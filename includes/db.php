<?php
require_once __DIR__ . '/config.php';

class DatabaseConnection {
    private static $pdo = null;

    public static function getConnection() {
        if (self::$pdo === null) {
            $dsnWithDb = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $dsnNoDb = 'mysql:host=' . DB_HOST . ';charset=utf8mb4';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            try {
                // First, try normal connection
                self::$pdo = new PDO($dsnWithDb, DB_USER, DB_PASS, $options);
                self::ensureSchema(self::$pdo);
            } catch (PDOException $e) {
                // If database is unknown (1049), attempt to create it automatically
                $isUnknownDb = (strpos($e->getMessage(), 'Unknown database') !== false) || ($e->getCode() == 1049);
                if ($isUnknownDb) {
                    try {
                        $pdoBootstrap = new PDO($dsnNoDb, DB_USER, DB_PASS, $options);
                        // Create database if needed
                        $pdoBootstrap->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                        $pdoBootstrap->exec("USE `" . DB_NAME . "`");
                        // Ensure customers table exists
                        $pdoBootstrap->exec(
                            "CREATE TABLE IF NOT EXISTS `customers` (
                              `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                              `name` VARCHAR(150) NOT NULL,
                              `location` VARCHAR(150) DEFAULT NULL,
                              `contact_number` VARCHAR(50) DEFAULT NULL,
                              `product` VARCHAR(150) DEFAULT NULL,
                              `amount_paid` DECIMAL(10,2) DEFAULT 0.00,
                              `cash_on_amount` DECIMAL(10,2) DEFAULT 0.00,
                              `delivery_option` VARCHAR(100) DEFAULT NULL,
                              `order_date` DATE NOT NULL,
                              `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                              `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                              PRIMARY KEY (`id`),
                              KEY `idx_name` (`name`),
                              KEY `idx_contact_number` (`contact_number`),
                              KEY `idx_product` (`product`),
                              KEY `idx_order_date` (`order_date`)
                            ) ENGINE=InnoDB"
                        );
                        // Reconnect to the newly ensured database
                        self::$pdo = new PDO($dsnWithDb, DB_USER, DB_PASS, $options);
                        self::ensureSchema(self::$pdo);
                    } catch (PDOException $inner) {
                        $message = 'Database auto-setup failed: ' . $inner->getMessage();
                        if (APP_DEBUG) {
                            die($message);
                        }
                        die('Database connection failed.');
                    }
                } else {
                    $message = 'Database connection failed: ' . $e->getMessage();
                    if (APP_DEBUG) {
                        die($message);
                    }
                    die('Database connection failed.');
                }
            }
        }
        return self::$pdo;
    }

    private static function ensureSchema(PDO $pdo): void {
        // Ensure expected columns exist or are removed as needed
        try {
            // Add cash_on_amount if missing
            $check = $pdo->query("SHOW COLUMNS FROM `customers` LIKE 'cash_on_amount'");
            if ($check->rowCount() === 0) {
                $pdo->exec("ALTER TABLE `customers` ADD COLUMN `cash_on_amount` DECIMAL(10,2) DEFAULT 0.00 AFTER `amount_paid`");
            }
        } catch (Throwable $e) {
            // ignore
        }

        try {
            // Drop legacy payment_type if present
            $check = $pdo->query("SHOW COLUMNS FROM `customers` LIKE 'payment_type'");
            if ($check->rowCount() > 0) {
                $pdo->exec("ALTER TABLE `customers` DROP COLUMN `payment_type`");
            }
        } catch (Throwable $e) {
            // ignore
        }

        try {
            // Ensure delivery_option exists
            $check = $pdo->query("SHOW COLUMNS FROM `customers` LIKE 'delivery_option'");
            if ($check->rowCount() === 0) {
                $pdo->exec("ALTER TABLE `customers` ADD COLUMN `delivery_option` VARCHAR(100) DEFAULT NULL AFTER `cash_on_amount`");
            }
        } catch (Throwable $e) {
            // ignore
        }
    }
}
?>


