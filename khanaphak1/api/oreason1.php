<?php 
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

$oc1_id = $_GET['oc1_id'];

$reasons = array();
foreach ($conn->query("SELECT * FROM oscore1 WHERE oc1_id = '$oc1_id' AND osc1_result = 0") as $row) {
    $reason = array(
        'osc1_reason' => $row['osc1_reason'],
    );
    array_push($reasons, $reason);
}
echo json_encode($reasons);
$conn = null;
?>