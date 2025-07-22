<?php 
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

$nc_id = $_GET['nc_id'];

$barcodes = array();
foreach ($conn->query("SELECT ns.s_no, m.m_username FROM nscore as ns inner join member as m on ns.m_id = m.m_id where ns.nc_id = '$nc_id' AND ns.nsc_result = 0") as $row) {
    $barcode = array(
        's_no' => $row['s_no'],
        'm_username' => $row['m_username'],
    );
    array_push($barcodes, $barcode);
}
echo json_encode($barcodes);
$conn = null;
?>