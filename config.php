<?php

define('HOST', 'localhost');
define('USER', 'leo');
define('PASS', 'leo1');
define('DB', 'forum');

// connection to the MySQL DB
$conn = mysqli_connect(HOST, USER, PASS, DB) 
        or die("Could not connect to database"); // exit("Could not ...");
?>