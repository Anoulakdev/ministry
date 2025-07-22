<?php
include '../config.php';

$sql15 = "SELECT count(DISTINCT s_no) as sno FROM nscore";
$result15 = $conn->query($sql15);
$row15 = $result15->fetch_assoc();
$sno = $row15['sno'];

echo 'ລົງ​ສຳ​ເລັດ: ' .$sno .' ໃບ';
?>