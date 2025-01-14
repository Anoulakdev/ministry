<?php 
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

$ochecks = array();
foreach ($conn->query('SELECT count(osc.m_id) / 6 as cm_id, m.m_username FROM oscore as osc inner join member as m on osc.m_id = m.m_id group by m.m_username order by cm_id desc') as $row) {
    $ocheck = array(
        
        'm_username' => $row['m_username'],
        'ocount' => $row['cm_id'],
    );
    array_push($ochecks, $ocheck);
}
echo json_encode($ochecks);
$conn = null;
?>