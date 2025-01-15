<?php
return [
    'up' => "INSERT INTO `users_profiles` (`user_id`, `bio`, `avatar`, `social_links`, `created_at`, `updated_at`) 
    VALUES 
    (1, 'Bio de John Doe. Passionné de technologie et de développement.', '/assets/images/users/johndoe.jpg', '{\"twitter\":\"https://twitter.com/johndoe\"}', NOW(), NOW()),
    (2, 'Bio de Jane Doe. Spécialiste en gestion de projet et mentor.', '/assets/images/users/janedoe.jpg', '{\"twitter\":\"https://twitter.com/janedoe\"}', NOW(), NOW()),
    (3, 'Bio de Pierre Dupont. Développeur et passionné de jeux vidéo.', '/assets/images/users/pierredupont.jpg', '{\"twitter\":\"https://twitter.com/pierredupont\"}', NOW(), NOW());",
    
    'down' => "DELETE FROM `users_profiles` WHERE `user_id` IN (1, 2, 3);",
];
