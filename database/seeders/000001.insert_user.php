<?php
return [
    'up' => "INSERT INTO `users` (`firstname`, `lastname`, `username`, `password`, `email`) 
    VALUES ('John', 'Doe', 'johndoe', '\$2y$10\$oawf2ccQ.GqS08a3C3RfsurQQhIgop2TJ/P4IxxVqug76dmXoe9uG', 'john.doe@example.com')",
    'down' => "DELETE FROM `users` WHERE `username` = 'johndoe'",
];