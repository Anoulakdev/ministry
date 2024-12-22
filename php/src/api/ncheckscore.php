<?php 
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

$nc_id = $_GET['nc_id'];

$reasons = array();
foreach ($conn->query("SELECT m.m_username FROM nscore as ns inner join member as m on ns.m_id = m.m_id WHERE ns.nc_id = '$nc_id'") as $row) {
    $reason = array(
        'm_username' => $row['m_username'],
    );
    array_push($reasons, $reason);
}
echo json_encode($reasons);
$conn->close();
?>