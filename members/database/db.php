<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_NAME', 'votting_system');
define('DB_PASS', 'Vicchi232312@');
define('DB_PORT', 3306);

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if (!$connection){
    die('Could not connect to the database');
}
