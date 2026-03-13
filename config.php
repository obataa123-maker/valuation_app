<?php

$host = "localhost:3306"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "newhurungu"; /* Database name */

$con = mysqli_connect($host, $user, $password, $dbname);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>