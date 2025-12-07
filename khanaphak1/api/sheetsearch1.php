<?php
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

// $s_no = $_GET['s_no'];

$barcodes = array();
foreach ($conn->query("SELECT ns1.*, nc1.nc1_name, m.m_username FROM nscore1 as ns1 inner join newcandidate1 as nc1 on ns1.nc1_id = nc1.nc1_id inner join member as m on ns1.m_id = m.m_id order by ns1.s_no asc") as $row) {
    $barcode = array(
        's_no' => $row['s_no'],
        'm_username' => $row['m_username'],
        'nc1_name' => $row['nc1_name'],
    );
    array_push($barcodes, $barcode);
}
echo json_encode($barcodes);
$conn = null;
