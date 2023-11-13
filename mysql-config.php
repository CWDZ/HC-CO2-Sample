<?php
$db_url = 'localhost';
$db_username = 'root';
$db_password = '';
$db_tablename = 'ioDataDB';
$con = @mysqli_connect($db_url, $db_username, $db_password, $db_tablename);
if (!$con) {
	echo "Error: " . mysqli_connect_error();
	exit();
}
mysqli_query($con, 'SET NAMES utf8mb4');
?>