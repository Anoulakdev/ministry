<?php

// Load the database configuration file 
include_once '../config.php';

// Include XLSX generator library 
require_once '../SimpleXLSXGen.php';

$oc1_id = $_GET['oc1_id'];
// Excel file name for download 
$fileName = date('YmdHis') . ".xlsx";

// Define column names 
$excelData[] = array('ລ/ດ', 'ຄຳ​ເຫັນ');

// Fetch records from database and store in an array 
$query = $conn->query("SELECT * FROM oscore1 WHERE oc1_id = '$oc1_id' AND osc1_result = 0");

$i = 1;
while ($row = $query->fetch_assoc()) {

    $lineData = array($i++, $row['osc1_reason']);
    $excelData[] = $lineData;
}

// Export data to excel and download as xlsx file 
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($excelData);
$xlsx->downloadAs($fileName);

exit;
