<?php
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

// $s_no = $_GET['s_no'];

$barcodes = array();
foreach ($conn->query("SELECT ns.*, nc.nc_name, m.m_username FROM nscore as ns inner join newcandidate as nc on ns.nc_id = nc.nc_id inner join member as m on ns.m_id = m.m_id where ns.nsc_result = 0 order by ns.s_no asc") as $row) {
    $barcode = array(
        'm_username' => $row['m_username'],
        's_no' => $row['s_no'],
        'nc_name' => $row['nc_name'],
    );
    array_push($barcodes, $barcode);
}
echo json_encode($barcodes);
$conn = null;
