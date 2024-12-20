<?php

return [
    'up' => "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `firstname` VARCHAR(255) NOT NULL,	
        `lastname` VARCHAR(255) NOT NULL,
        `username` VARCHAR(255) NOT NULL UNIQUE,
        `email` VARCHAR(255) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `role` ENUM('admin', 'user', 'moderator') NOT NULL DEFAULT 'user',
        `birthdate` DATE NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
    'down' => "DROP TABLE IF EXISTS `users`",
];