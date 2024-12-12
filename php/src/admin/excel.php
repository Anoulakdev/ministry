<?php 
 
// Load the database configuration file 
include_once '../config.php'; 
 
// Include XLSX generator library 
require_once '../SimpleXLSXGen.php'; 

// Excel file name for download 
$fileName = date('YmdHis') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('ລ/ດ', 'ຜູ້​ສະ​ໝັກ​ຊຸ​ດ​ເກົ່າ', '​ຜູ້​ສະ​ໝັກ​ເປົ້າ​ໝາຍ​ໃໝ່', 'ຊື່​ເຂົ້າ​ລະ​ບົບ', '​ລະ​ຫັດ'); 
 
// Fetch records from database and store in an array 
$query = $conn->query("SELECT * FROM member"); 

    $i = 1;
    while($row = $query->fetch_assoc()){ 
        
        $sql = $conn->query("SELECT m_id FROM oscore WHERE m_id = '" . $row['m_id'] . "'");
        $row_cnt = $sql->num_rows;

        if ($row_cnt > 0) {
            $oc = 'ທ່ານ​ລົງ​ຄະ​ແນນ​ສຳ​ເລັ​ດ​ແລ້​ວ';
        } else {
            $oc = 'ທ່ານ​ຍັງ​ບໍ່​ທັນ​ລົງ​ຄະ​ແນນ';
        }

        $sql1 = $conn->query("SELECT m_id FROM nscore WHERE m_id = '" . $row['m_id'] . "'");
        $row_cnt1 = $sql1->num_rows;

        if ($row_cnt1 > 0) {
            $nc = 'ທ່ານ​ລົງ​ຄະ​ແນນ​ສຳ​ເລັ​ດ​ແລ້​ວ';
        } else {
            $nc = 'ທ່ານ​ຍັງ​ບໍ່​ທັນ​ລົງ​ຄະ​ແນນ';
        }


        $lineData = array($i++, $oc, $nc, $row['m_username'], $row['m_password']);  
        $excelData[] = $lineData; 
    } 

 
// Export data to excel and download as xlsx file 
$xlsx = Shuchkin\SimpleXLSXGen::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>
