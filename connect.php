<?php
$servername = "localhost";
$username = "root";
$password = "";
$message = "";
$dbname = "tracnghiem";

try {
  $dsn = 'mysql:host='.$servername.';dbname='.$dbname;
  $conn = new PDO("mysql:host=$servername;dbname=tracnghiem", $username, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>