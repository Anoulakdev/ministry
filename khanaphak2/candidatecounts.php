<?php
include 'config.php';

$sql15 = "SELECT count(nc_id) as cnc FROM newcandidate";
$result15 = $conn->query($sql15);
$row15 = $result15->fetch_assoc();
$cnc = $row15['cnc'];
?>
