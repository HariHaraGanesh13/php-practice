
<?php

require 'src/User.php';

$user = new User("Hari", "hari@example.com");
echo $user->getProfile();
