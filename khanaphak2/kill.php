<?php
include 'config.php';

$sql10 = "SELECT * FROM sys WHERE s_id = 1";
$result10 = $conn->query($sql10);
$row10 = $result10->fetch_assoc();
$kill = $row10['s_kill'];
?>