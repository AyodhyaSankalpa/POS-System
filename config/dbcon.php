<?php

define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DB','pos_system');

date_default_timezone_set('Asia/Colombo');

$conn = mysqli_connect(HOST,USER,PASS,DB);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}   

?>