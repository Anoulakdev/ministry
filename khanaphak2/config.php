<?php
$DBHOST = 'db';
$DBUSER = 'root';
$DBPASS = 'xayasone';
$DBNAME = 'khanaphak2';

$conn = new mysqli($DBHOST, $DBUSER, $DBPASS, $DBNAME);
mysqli_set_charset($conn, "utf8");
date_default_timezone_set('Asia/Vientiane');

if ($conn->connect_error) {
	die('Could not connect to the database!' . $conn->connect_error);
}
