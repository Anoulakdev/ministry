<?php 
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

$oc2_id = $_GET['oc2_id'];

$reasons = array();
foreach ($conn->query("SELECT * FROM oscore2 WHERE oc2_id = '$oc2_id' AND osc2_result = 0") as $row) {
    $reason = array(
        'osc2_reason' => $row['osc2_reason'],
    );
    array_push($reasons, $reason);
}
echo json_encode($reasons);
$conn = null;
?>