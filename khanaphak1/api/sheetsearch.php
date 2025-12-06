<?php
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

$s_no = $_GET['s_no'];

$barcodes = array();
foreach ($conn->query("SELECT nc.* FROM nscore as ns inner join newcandidate as nc on ns.nc_id = nc.nc_id where ns.s_no = '$s_no' AND ns.nsc_result = 0 order by nc.nc_id asc") as $row) {
    $barcode = array(
        'nc_pic' => $row['nc_pic'],
        'nc_name' => $row['nc_name'],
    );
    array_push($barcodes, $barcode);
}
echo json_encode($barcodes);
$conn = null;
