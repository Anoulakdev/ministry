<?php
include '../config.php';

$sql15 = "SELECT count(DISTINCT m_id) as mid FROM nscore";
$result15 = $conn->query($sql15);
$row15 = $result15->fetch_assoc();
$mid = $row15['mid'];

echo 'ລົງ​ສຳ​ເລັດ: ' .$mid .' ທ່ານ';
?>