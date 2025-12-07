<?php
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

// $s_no = $_GET['s_no'];

$barcodes = array();
foreach ($conn->query("SELECT os.*, oc.oc_name, m.m_username FROM oscore as os inner join oldcandidate as oc on os.oc_id = oc.oc_id inner join member as m on os.m_id = m.m_id where os.osc_result = 0 order by os.s_no asc") as $row) {
    $barcode = array(
        'm_username' => $row['m_username'],
        's_no' => $row['s_no'],
        'oc_name' => $row['oc_name'],
    );
    array_push($barcodes, $barcode);
}
echo json_encode($barcodes);
$conn = null;
