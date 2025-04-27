# -- =============================================
# -- Database Schema Script for Laravel Mini E-Commerce
# -- Generated based on Laravel Migrations
# -- =============================================
#
# -- WARNING: This script will DROP existing tables if they exist.
#
# SET
# FOREIGN_KEY_CHECKS=0; -- Disable FK checks (MySQL specific)
#
# DROP TABLE IF EXISTS `failed_jobs`;
# DROP TABLE IF EXISTS `migrations`;
# DROP TABLE IF EXISTS `order_items`;
# DROP TABLE IF EXISTS `orders`;
# DROP TABLE IF EXISTS `password_reset_tokens`;
# DROP TABLE IF EXISTS `personal_access_tokens`; -- If using Sanctum/Passport
# DROP TABLE IF EXISTS `products`;
# DROP TABLE IF EXISTS `users`;
#
# -- Paste the CREATE TABLE statement for `users` from `migrate --pretend` output here
# CREATE TABLE `users`
# (
#     `id`                bigint unsigned NOT NULL AUTO_INCREMENT,
#     `name`              varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
#     `email`             varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
#     `email_verified_at` timestamp NULL DEFAULT NULL,
#     `password`          varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
#     `remember_token`    varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
#     `created_at`        timestamp NULL DEFAULT NULL,
#     `updated_at`        timestamp NULL DEFAULT NULL,
#     PRIMARY KEY (`id`),
#     UNIQUE KEY `users_email_unique` (`email`)
# ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
#
# -- Paste the CREATE TABLE statement for `password_reset_tokens` from `migrate --pretend` output here
# CREATE TABLE `password_reset_tokens`
# (
#     `email`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
#     `token`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
#     `created_at` timestamp NULL DEFAULT NULL,
#     PRIMARY KEY (`email`)
# ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
#
# -- Paste the CREATE TABLE statement for `failed_jobs` from `migrate --pretend` output here
# CREATE TABLE `failed_jobs`
# (
#     `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
#     `uuid`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
#     `connection` text COLLATE utf8mb4_unicode_ci         NOT NULL,
#     `queue`      text COLLATE utf8mb4_unicode_ci         NOT NULL,
#     `payload`    longtext COLLATE utf8mb4_unicode_ci     NOT NULL,
#     `exception`  longtext COLLATE utf8mb4_unicode_ci     NOT NULL,
#     `failed_at`  timestamp                               NOT NULL DEFAULT CURRENT_TIMESTAMP,
#     PRIMARY KEY (`id`),
#     UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
# ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
#
# -- Paste the CREATE TABLE statement for `personal_access_tokens` (if applicable) here
# -- CREATE TABLE `personal_access_tokens` (...) ENGINE=InnoDB;
#
# -- Paste the CREATE TABLE statement for `products` from `migrate --pretend` output here
# CREATE TABLE `products`
# (
#     `id`             bigint unsigned NOT NULL AUTO_INCREMENT,
#     `name`           varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
#     `category`       varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
#     `description`    text COLLATE utf8mb4_unicode_ci,
#     `price`          decimal(8, 2)                           NOT NULL,
#     `image`          varchar(255) COLLATE utf8mb4_unicode_ci          DEFAULT NULL,
#     `stock_quantity` int                                     NOT NULL DEFAULT '0',
#     `created_at`     timestamp NULL DEFAULT NULL,
#     `updated_at`     timestamp NULL DEFAULT NULL,
#     PRIMARY KEY (`id`)
# ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
#
# -- Paste the CREATE TABLE statement for `orders` from `migrate --pretend` output here
# CREATE TABLE `orders`
# (
#     `id`               bigint unsigned NOT NULL AUTO_INCREMENT,
#     `user_id`          bigint unsigned DEFAULT NULL,                                                         -- Allow NULL
#     `customer_name`    varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
#     `customer_email`   varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
#     `shipping_address` text COLLATE utf8mb4_unicode_ci         NOT NULL,
#     `payment_type`     varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
#     `total_amount`     decimal(10, 2)                          NOT NULL,
#     `status`           varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
#     `created_at`       timestamp NULL DEFAULT NULL,
#     `updated_at`       timestamp NULL DEFAULT NULL,
#     PRIMARY KEY (`id`),
#     KEY                `orders_user_id_foreign` (`user_id`),
#     CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL -- Use SET NULL on delete
# ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
#
# -- Paste the CREATE TABLE statement for `order_items` from `migrate --pretend` output here
# CREATE TABLE `order_items`
# (
#     `id`           bigint unsigned NOT NULL AUTO_INCREMENT,
#     `order_id`     bigint unsigned NOT NULL,
#     `product_id`   bigint unsigned DEFAULT NULL,                                                                           -- Allow NULL
#     `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
#     `quantity`     int                                     NOT NULL,
#     `price`        decimal(8, 2)                           NOT NULL,
#     `created_at`   timestamp NULL DEFAULT NULL,
#     `updated_at`   timestamp NULL DEFAULT NULL,
#     PRIMARY KEY (`id`),
#     KEY            `order_items_order_id_foreign` (`order_id`),
#     KEY            `order_items_product_id_foreign` (`product_id`),
#     CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,       -- Cascade delete here
#     CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL -- Use SET NULL on delete
# ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
#
# -- Paste the CREATE TABLE statement for `migrations` from `migrate --pretend` output here
# CREATE TABLE `migrations`
# (
#     `id`        int unsigned NOT NULL AUTO_INCREMENT,
#     `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
#     `batch`     int                                     NOT NULL,
#     PRIMARY KEY (`id`)
# ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
#
#
# SET
# FOREIGN_KEY_CHECKS=1; -- Re-enable FK checks (MySQL specific)
#
# -- =============================================
# -- End of Schema Script
# -- =============================================
