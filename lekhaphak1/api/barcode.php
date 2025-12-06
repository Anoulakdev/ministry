<?php
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

$m_id = $_GET['m_id'];

$barcodes = array();
foreach ($conn->query("SELECT nc.* FROM nscore as ns inner join newcandidate as nc on ns.nc_id = nc.nc_id where ns.m_id = '$m_id' order by ns.nsc_id desc limit 20") as $row) {
    $barcode = array(
        'nc_pic' => $row['nc_pic'],
        'nc_name' => $row['nc_name'],
    );
    array_push($barcodes, $barcode);
}
echo json_encode($barcodes);
$conn = null;
