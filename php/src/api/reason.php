<?php 
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

$oc_id = $_GET['oc_id'];

$reasons = array();
foreach ($conn->query("SELECT * FROM oscore WHERE oc_id = '$oc_id' AND osc_result = 0") as $row) {
    $reason = array(
        'osc_reason' => $row['osc_reason'],
    );
    array_push($reasons, $reason);
}
echo json_encode($reasons);
$conn->close();
?>