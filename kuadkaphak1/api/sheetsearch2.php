<?php
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

// $s_no = $_GET['s_no'];

$barcodes = array();
foreach ($conn->query("SELECT ns2.*, nc2.nc2_name, m.m_username FROM nscore2 as ns2 inner join newcandidate2 as nc2 on ns2.nc2_id = nc2.nc2_id inner join member as m on ns2.m_id = m.m_id order by ns2.s_no asc") as $row) {
    $barcode = array(
        's_no' => $row['s_no'],
        'm_username' => $row['m_username'],
        'nc2_name' => $row['nc2_name'],
    );
    array_push($barcodes, $barcode);
}
echo json_encode($barcodes);
$conn = null;
