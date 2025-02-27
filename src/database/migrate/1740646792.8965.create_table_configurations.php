<?php return [
    'up' => "CREATE TABLE `configurations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(255) DEFAULT NULL,
  `type` enum('integer','float','bool','string','text') DEFAULT NULL,
  `integer_value` int(11) DEFAULT NULL,
  `float_value` decimal(10,0) DEFAULT NULL,
  `bool_value` tinyint(1) DEFAULT NULL,
  `string_value` varchar(255) DEFAULT NULL,
  `text_value` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",
    'down' => "DROP TABLE IF EXISTS `configurations`;",
]; 