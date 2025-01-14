<?php
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

$nchecks = array();
foreach ($conn->query('SELECT count(nsc.m_id) / 33 as cm_id, m.m_username FROM nscore as nsc inner join member as m on nsc.m_id = m.m_id group by m.m_username order by cm_id desc') as $row) {
    $ncheck = array(

        'm_username' => $row['m_username'],
        'ncount' => $row['cm_id'],
    );
    array_push($nchecks, $ncheck);
}
echo json_encode($nchecks);
$conn = null;
