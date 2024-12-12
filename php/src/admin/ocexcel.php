<?php

// Load the database configuration file 
include_once '../config.php';

// Include XLSX generator library 
require_once '../SimpleXLSXGen.php';

$oc_id = $_GET['oc_id'];
// Excel file name for download 
$fileName = date('YmdHis') . ".xlsx";

// Define column names 
$excelData[] = array('ລ/ດ', 'ຄຳ​ເຫັນ');

// Fetch records from database and store in an array 
$query = $conn->query("SELECT * FROM oscore WHERE oc_id = '$oc_id' AND osc_result = 0");

$i = 1;
while ($row = $query->fetch_assoc()) {

    $lineData = array($i++, $row['osc_reason']);
    $excelData[] = $lineData;
}

// Export data to excel and download as xlsx file 
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($excelData);
$xlsx->downloadAs($fileName);

exit;
