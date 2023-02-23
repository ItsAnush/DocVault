<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'whale_enterprises';

#$host = '127.0.0.1';
#$user = 'root';
#$pass = 'root';
#$dbname = 'whale_enterprises';

$link = mysqli_connect($host, $user, $pass, $dbname);
if (!$link) {
  die('Could not connect: ' . mysqli_connect_error());
}
