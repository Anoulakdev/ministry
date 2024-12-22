<?php 
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

$memberdeletes = array();
foreach ($conn->query('SELECT DISTINCT m.m_id, m.m_username FROM oscore as oc inner join member as m on oc.m_id = m.m_id') as $row) {
    $memberdelete = array(
        'm_id' => $row['m_id'],
        'm_username' => $row['m_username'],
    );
    array_push($memberdeletes, $memberdelete);
}
echo json_encode($memberdeletes);
$conn->close();
?>