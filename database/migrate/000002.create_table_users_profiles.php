<?php

return [
    'up' => "CREATE TABLE IF NOT EXISTS `users_profiles` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT NOT NULL,
        `bio` TEXT NULL,
        `social_links` JSON NULL,
        `avatar` VARCHAR(255) NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    )",
    'down' => "DROP TABLE IF EXISTS `users_profiles`",
];
