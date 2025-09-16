-- Create database (run once if not already created)
CREATE DATABASE IF NOT EXISTS `customer_records` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `customer_records`;

-- Customers table
CREATE TABLE IF NOT EXISTS `customers` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `location` VARCHAR(150) DEFAULT NULL,
  `contact_number` VARCHAR(50) DEFAULT NULL,
  `product` VARCHAR(150) DEFAULT NULL,
  `amount_paid` DECIMAL(10,2) DEFAULT 0.00,
  `payment_type` ENUM('COD','Prepaid') NOT NULL DEFAULT 'COD',
  `delivery_option` VARCHAR(100) DEFAULT NULL,
  `order_date` DATE NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_contact_number` (`contact_number`),
  KEY `idx_product` (`product`),
  KEY `idx_order_date` (`order_date`)
) ENGINE=InnoDB;


