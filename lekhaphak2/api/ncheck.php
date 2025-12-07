<?php 
header("Access-Control-Allow-Origin: *");
header("content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config.php";
include "../candidatecounts.php";

$nchecks = array();
foreach ($conn->query("SELECT count(s_no) / $cnc as sno, s_no FROM nscore group by s_no order by sno asc") as $row) {
    $ncheck = array(
        
        's_no' => $row['s_no'],
        'sno' => $row['sno'],
    );
    array_push($nchecks, $ncheck);
}
echo json_encode($nchecks);
$conn = null;
?>