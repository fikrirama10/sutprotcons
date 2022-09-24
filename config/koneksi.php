<?php
$server = "localhost";
// $username = "akses_luar";
// $password = "P@ssw0rd^&@2019Laydip*";
// $database = "db_sitprotkons";
$username = "root";
$password = "";
$database = "kemlu";
//$database = "deplu31";
// Koneksi dan memilih database di server
$link = mysqli_connect($server,$username,$password,$database) or die("Koneksi gagal");
?>
