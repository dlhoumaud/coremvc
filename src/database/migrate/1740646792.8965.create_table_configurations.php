<?php return [
    'up' => "CREATE TABLE IF NOT EXISTS `configurations` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `config_key` varchar(255) DEFAULT NULL,
      `type` enum('integer','float','bool','string','text') DEFAULT NULL,
      `integer_value` int(11) DEFAULT NULL,
      `float_value` decimal(10,0) DEFAULT NULL,
      `bool_value` tinyint(1) DEFAULT NULL,
      `string_value` varchar(255) DEFAULT NULL,
      `text_value` text DEFAULT NULL
    )",
    'down' => "DROP TABLE IF EXISTS `configurations`;",
]; 