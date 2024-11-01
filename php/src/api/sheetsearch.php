<?php 
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

$s_no = $_GET['s_no'];

$barcodes = array();
foreach ($conn->query("SELECT nc.* FROM nscore as ns inner join newcandidate as nc on ns.nc_id = nc.nc_id where ns.s_no = '$s_no' order by nc.nc_id asc") as $row) {
    $barcode = array(
        'nc_pic' => $row['nc_pic'],
        'nc_name' => $row['nc_name'],
        'nc_age' => $row['nc_age'],
        'nc_saonoum' => $row['nc_saonoum'],
        'nc_lat' => $row['nc_lat'],
        'nc_phak' => $row['nc_phak'],
        'nc_part' => $row['nc_part'],
        'nc_reason' => $row['nc_reason'],
    );
    array_push($barcodes, $barcode);
}
echo json_encode($barcodes);
$conn = null;
?>