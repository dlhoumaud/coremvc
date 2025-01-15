<?php

return [
    'up' => "CREATE TABLE IF NOT EXISTS `articles` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT NOT NULL,
        `title` VARCHAR(255) NULL,
        `description` TEXT NULL,
        `contents` TEXT NULL,
        `image` VARCHAR(255) NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    )",
    'down' => "DROP TABLE IF EXISTS `articles`",
];
