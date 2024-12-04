<?php
return [
    'up' => "INSERT INTO `users` (`firstname`, `lastname`, `username`, `email`, `password`, `role`, `birthdate`) 
    VALUES ('John', 'Doe', 'johndoe', 'john.doe@example.com', '\$2y$10\$oawf2ccQ.GqS08a3C3RfsurQQhIgop2TJ/P4IxxVqug76dmXoe9uG', 'admin', '1983-05-16'),
    ('Jane', 'Doe', 'janedoe', 'jane.doe@example.com', '\$2y$10\$oawf2ccQ.GqS08a3C3RfsurQQhIgop2TJ/P4IxxVqug76dmXoe9uG', 'moderator', '1983-05-16'),
    ('Pierre', 'Dupont', 'pierredupont', 'pierre.dupont@example.com', '\$2y$10\$oawf2ccQ.GqS08a3C3RfsurQQhIgop2TJ/P4IxxVqug76dmXoe9uG', 'user', '1983-05-16');",
    'down' => "DELETE FROM `users` WHERE `id` IN (1, 2, 3);",
];