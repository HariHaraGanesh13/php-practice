
<?php

require 'src/User.php';

$user = new User("Hari", "hariharaganesh@gmail.com");
echo $user->getProfile();
