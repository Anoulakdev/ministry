<?php
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";

$ochecks = array();

// Query ข้อมูลจากฐานข้อมูล
$query = "SELECT count(osc.m_id) / 10 as cm_id, m.m_username 
          FROM oscore as osc 
          INNER JOIN member as m ON osc.m_id = m.m_id 
          GROUP BY m.m_username 
          ORDER BY cm_id DESC";

$result = $conn->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $ocheck = array(
            'm_username' => $row['m_username'],
            'ocount' => $row['cm_id'],
        );
        array_push($ochecks, $ocheck);
    }
    $result->close(); // ปิด result set
}

echo json_encode($ochecks);

$conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล
