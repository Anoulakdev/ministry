<?php

// Load the database configuration file 
include_once '../config.php';

// Include XLSX generator library 
require_once '../SimpleXLSXGen.php';

// Excel file name for download 
$fileName = date('YmdHis') . ".xlsx";

// Define column names 
$excelData[] = array('ລ/ດ', 'ຊື່ ແລະ ນາມ​ສະ​ກຸນ', '​ອາ​ຍຸ', 'ຕຳ​ແໜ່ງແມ່​ຍິງ', '​ຕຳ​ແໜ່ງ​ລັດ', 'ຕຳ​ແໜ່ງພັກ', '​ກົມ​ກອງ​ປະ​ຈຳ​ການ', '​ຄະ​ແນນ​ໄດ້', '​ຄະ​ແນນ​ເສຍ', '​ສະ​ເລ່ຍ​ຄະ​ແນນ​ເສຍ');

// Fetch records from database and store in an array 
$query = $conn->query("SELECT sum(sc.nsc_result) as scres, nc.nc_id, nc.nc_name, nc.nc_age, nc.nc_women, nc.nc_lat, nc.nc_phak, nc.nc_part FROM nscore as sc right join newcandidate as nc on sc.nc_id = nc.nc_id group by nc.nc_name order by scres DESC, nc.nc_id ASC");

$sql10 = "SELECT count(DISTINCT s_no) as sno FROM nscore";
$result10 = $conn->query($sql10);
$row10 = $result10->fetch_assoc();
$sno = $row10['sno'];

$i = 1;
while ($row = $query->fetch_assoc()) {

    $scoreplus = $row['scres'] ? $row['scres'] : 0;

    if ($row['scres']) {
        $scres = $row['scres'];
        $scoreminus = $sno - $scres;
    } else {
        $scoreminus = $sno;
    }

    if ($row['scres']) {
        $scres = $row['scres'];
        $tores = $sno - $scres;
        $percent = ($tores / $sno) * 100;
    } else {
        if ($sno) {
            $scres = $row['scres'];
            $tores = $sno - $scres;
            $percent = ($tores / $sno) * 100;
        } else {
            $percent = '0.00';
        }
    }

    $lineData = array($i++, $row['nc_name'], $row['nc_age'], $row['nc_women'], $row['nc_lat'], $row['nc_phak'], $row['nc_part'], $scoreplus, $scoreminus, number_format($percent, 2));
    $excelData[] = $lineData;
}


// Export data to excel and download as xlsx file 
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($excelData);
$xlsx->downloadAs($fileName);

exit;
