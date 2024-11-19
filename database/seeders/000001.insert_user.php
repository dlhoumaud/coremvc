<?php
return [
    'up' => "INSERT INTO `users` (`firstname`, `lastname`, `username`, `password`, `email`) 
    VALUES ('John', 'Doe', 'johndoe', 'password123', 'john.doe@example.com')",
    'down' => "DELETE FROM `users` WHERE `username` = 'johndoe'",
];