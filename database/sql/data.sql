-- =============================================
-- Dummy Data Script for Laravel Mini E-Commerce
-- =============================================

-- WARNING: This script will DELETE existing data in the specified tables.
-- Uncomment and use with caution, especially the SET FOREIGN_KEY_CHECKS lines if needed.

-- SET FOREIGN_KEY_CHECKS = 0; -- Disable FK checks (MySQL specific)

-- DELETE FROM order_items;
-- DELETE FROM orders;
-- DELETE FROM products;
-- DELETE FROM users;

-- SET FOREIGN_KEY_CHECKS = 1; -- Re-enable FK checks (MySQL specific)


-- -------------------------
-- Users Table
-- Password hash is for 'password' using Bcrypt
-- -------------------------
INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES ('Alice Wonder', 'alice@example.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        NULL, NOW(), NOW()),
       ('Bob The Builder', 'bob@example.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        NULL, NOW(), NOW()),
       ('Charlie Chaplin', 'charlie@example.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        NULL, NOW(), NOW()),
       ('Admin User', 'admin@example.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL,
        NOW(), NOW());
-- Example Admin


-- -------------------------
-- Products Table
-- -------------------------
INSERT INTO `products` (`name`, `category`, `description`, `price`, `image`, `stock_quantity`, `created_at`,
                        `updated_at`)
VALUES ('Ergo Wireless Mouse', 'Peripherals',
        'A comfortable and reliable ergonomic wireless mouse with long battery life.', 29.99,
        '/storage/products/ergo_mouse.jpg', 55, NOW(), NOW()),
       ('Mechanical Keyboard (RGB)', 'Peripherals',
        'Tactile mechanical keyboard with customizable RGB backlighting and programmable keys.', 89.95,
        '/storage/products/mech_keyboard.jpg', 30, NOW(), NOW()),
       ('USB-C Hub 7-in-1', 'Accessories',
        'Expand your laptop connectivity with HDMI, USB 3.0, SD/microSD card slots, and USB-C power delivery.', 35.50,
        '/storage/products/usbc_hub.jpg', 110, NOW(), NOW()),
       ('Active Noise Cancelling Headphones', 'Audio',
        'Immersive sound with industry-leading active noise cancellation. Perfect for travel and focus.', 149.00,
        '/storage/products/anc_headphones.jpg', 22, NOW(), NOW()),
       ('Portable SSD 1TB', 'Storage',
        'Blazing fast external SSD storage for quick file transfers and backups. Compact and durable.', 99.99,
        '/storage/products/portable_ssd.jpg', 40, NOW(), NOW()),
       ('1080p Webcam with Ring Light', 'Peripherals',
        'Full HD webcam featuring a built-in adjustable ring light for clear video calls.', 45.00,
        '/storage/products/webcam_ringlight.jpg', 75, NOW(), NOW()),
       ('XL Gaming Mousepad', 'Accessories',
        'Extended surface mousepad providing ample space for mouse movement and keyboard placement.', 19.99,
        '/storage/products/xl_mousepad.jpg', 250, NOW(), NOW()),

       ('Waterproof Bluetooth Speaker', 'Audio',
        'Rugged and portable Bluetooth speaker with IPX7 waterproof rating and rich sound.', 55.00,
        '/storage/products/bluetooth_speaker.jpg', 60, NOW(),NOW()),

       ('Adjustable Laptop Stand', 'Accessories', 'Ergonomic aluminum laptop stand to improve posture and cooling.',
        24.99, '/storage/products/laptop_stand.jpg', 90, NOW(), NOW()),
       ('27-inch QHD Monitor', 'Peripherals',
        'Crisp 2560x1440 resolution monitor with thin bezels, ideal for productivity and gaming.', 299.99,
        '/storage/products/qhd_monitor.jpg', 15, NOW(), NOW()),
       ('Smart LED Desk Lamp', 'Accessories',
        'Desk lamp with adjustable brightness, color temperature, and smart controls.', 39.95,
        '/storage/products/desk_lamp.jpg', 50, NOW(), NOW()),
       ('Wireless Charging Pad', 'Accessories',
        'Qi-certified fast wireless charging pad for compatible smartphones and earbuds.', 18.50,
        '/storage/products/wireless_charger.jpg', 120, NOW(), NOW());


-- -------------------------
-- Orders Table
-- Assumes User IDs 1, 2, 3 exist from above
-- -------------------------
INSERT INTO `orders` (`user_id`, `customer_name`, `customer_email`, `shipping_address`, `payment_type`, `total_amount`,
                      `status`, `created_at`, `updated_at`)
VALUES (1, 'Alice Wonder', 'alice@example.com', '123 Wonderland Ave, Fantasy City, FS 10001', 'card', 119.94,
        'completed', NOW() - INTERVAL 3 DAY, NOW() - INTERVAL 3 DAY),
       (2, 'Bob The Builder', 'bob@example.com', '456 Construction Ln, Toolsville, TS 20002', 'cash_on_delivery', 90.50,
        'shipped', NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 1 DAY),
       (1, 'Alice Wonder', 'alice@example.com', '123 Wonderland Ave, Fantasy City, FS 10001', 'card', 167.50,
        'processing', NOW() - INTERVAL 1 DAY, NOW()),
       (3, 'Charlie Chaplin', 'charlie@example.com', '789 Silent Film Rd, Hollywood, CA 90210', 'card', 45.00,
        'pending', NOW() - INTERVAL 5 HOUR, NOW() - INTERVAL 5 HOUR),
       (2, 'Bob The Builder', 'bob@example.com', '456 Construction Ln, Toolsville, TS 20002', 'card', 299.99,
        'completed', NOW() - INTERVAL 4 DAY, NOW() - INTERVAL 4 DAY);


-- -------------------------
-- Order Items Table
-- Assumes Order IDs 1, 2, 3, 4, 5 exist from above
-- Assumes Product IDs 1-12 exist from above
-- Product Name and Price are copied from the product at the time of insertion
-- -------------------------

-- Order 1 Items (ID: 1)
INSERT INTO `order_items` (`order_id`, `product_id`, `product_name`, `quantity`, `price`, `created_at`, `updated_at`)
VALUES (1, 1, 'Ergo Wireless Mouse', 1, 29.99, NOW() - INTERVAL 3 DAY, NOW() - INTERVAL 3 DAY),
       (1, 2, 'Mechanical Keyboard (RGB)', 1, 89.95, NOW() - INTERVAL 3 DAY, NOW() - INTERVAL 3 DAY);

-- Order 2 Items (ID: 2)
INSERT INTO `order_items` (`order_id`, `product_id`, `product_name`, `quantity`, `price`, `created_at`, `updated_at`)
VALUES (2, 3, 'USB-C Hub 7-in-1', 1, 35.50, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 1 DAY),
       (2, 8, 'Waterproof Bluetooth Speaker', 1, 55.00, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 1 DAY);

-- Order 3 Items (ID: 3)
INSERT INTO `order_items` (`order_id`, `product_id`, `product_name`, `quantity`, `price`, `created_at`, `updated_at`)
VALUES (3, 4, 'Active Noise Cancelling Headphones', 1, 149.00, NOW() - INTERVAL 1 DAY, NOW()),
       (3, 12, 'Wireless Charging Pad', 1, 18.50, NOW() - INTERVAL 1 DAY, NOW());

-- Order 4 Items (ID: 4)
INSERT INTO `order_items` (`order_id`, `product_id`, `product_name`, `quantity`, `price`, `created_at`, `updated_at`)
VALUES (4, 6, '1080p Webcam with Ring Light', 1, 45.00, NOW() - INTERVAL 5 HOUR, NOW() - INTERVAL 5 HOUR);

-- Order 5 Items (ID: 5)
INSERT INTO `order_items` (`order_id`, `product_id`, `product_name`, `quantity`, `price`, `created_at`, `updated_at`)
VALUES (5, 10, '27-inch QHD Monitor', 1, 299.99, NOW() - INTERVAL 4 DAY, NOW() - INTERVAL 4 DAY);


-- =============================================
-- End of Script
-- =============================================
