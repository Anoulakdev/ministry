<?php
include 'config.php';

$sql15 = "SELECT count(oc1_id) as coc1 FROM oldcandidate1";
$result15 = $conn->query($sql15);
$row15 = $result15->fetch_assoc();
$coc1 = $row15['coc1'];

$sql16 = "SELECT count(oc2_id) as coc2 FROM oldcandidate2";
$result16 = $conn->query($sql16);
$row16 = $result16->fetch_assoc();
$coc2 = $row16['coc2'];

$sql17 = "SELECT count(nc1_id) as cnc1 FROM newcandidate1";
$result17 = $conn->query($sql17);
$row17 = $result17->fetch_assoc();
$cnc1 = $row17['cnc1'];

$sql18 = "SELECT count(nc2_id) as cnc2 FROM newcandidate2";
$result18 = $conn->query($sql18);
$row18 = $result18->fetch_assoc();
$cnc2 = $row18['cnc2'];
