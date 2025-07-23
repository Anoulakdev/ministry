<?php
require_once('../tcpdf/tcpdf.php');
include '../config.php';

// Get the s_id from the URL
$id = $_GET['s_id'];

// Retrieve data from the database
$sql = "SELECT * FROM sheet WHERE s_id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$s_no = $row['s_no'];

$html = '<table border="1" cellpadding="4" width="100%">';
$html .= '<tr>
            <th rowspan="2" width="4%" style="text-align:center; vertical-align:middle;">ລ/ດ</th>
            <th rowspan="2" width="19%" style="text-align:center; vertical-align:middle;">​ຊື່ ແລະ ນາມ​ສະ​ກຸນ</th>
            <th rowspan="2" width="5%" style="text-align:center; vertical-align:middle;">​ອາ​ຍຸ</th>
            <th colspan="3" width="44.7%" style="text-align:center; vertical-align:middle;">ຕຳ​ແໜ່ງ</th>
            <th rowspan="2" width="10%" style="text-align:center; vertical-align:middle;">ທິດ​ສະ​ດີ</th>
            <th rowspan="2" width="16%" style="text-align:center; vertical-align:middle;">ກົມ​ກອງ</th>
        </tr>
        <tr>
            <th width="20.6%" style="text-align:center; vertical-align:middle;">ກຳ​ມະ​ບານ</th>
            <th width="12.6%" style="text-align:center; vertical-align:middle;">​ລັດ</th>
            <th width="11.5%" style="text-align:center; vertical-align:middle;">ພັກ</th>
        </tr>';
$html .= '</table>';

// Create new PDF document
$pdf = new TCPDF("P", "mm", "A4", true, 'UTF-8', false);
$pdf->SetMargins(4, 6, 2);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(true, 0);
// Add a new page
$pdf->AddPage();

// Set fonts and title
$pdf->SetFont('phetsarath_ot', '', 14, '', true);
$pdf->SetFontSize(18);
$pdf->SetFont('', 'B');
$pdf->Cell(67, 10, '', 0, 0, 'C');
$pdf->Cell(67, 10, 'ບັດທາບ​ທາມ', 0, 0, 'C');
$pdf->SetTextColor(0, 0, 255);
$pdf->write1DBarcode($s_no, 'C128', '', '', '', 16, 0.5, array(
    'position' => 'R',
    'align' => 'B',
    'stretch' => true,
    'fitwidth' => true,
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false,
    'text' => true,
    'font' => 'phetsarath_ot',
    'fontsize' => 5,
    'stretchtext' => 28,
), 'N');

$pdf->SetFontSize(14);
$pdf->SetFont('', 'B');
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 10, 'ຄະນະບໍລິຫານງານສະຫະພັນກໍາມະບານ ກະຊວງອຸດສາຫະກໍາ ແລະ ການຄ້າ (ຊຸດໃໝ່)', 0, 1, 'C');

$pdf->SetFont('phetsarath_ot', '', 10);

$pdf->writeHTML($html, false, false, true, false, '');

$pdf->SetFontSize(9);
$pdf->SetFont('');
$pdf->SetFillColor(255, 255, 255);
$sql3 = "SELECT * FROM newcandidate";
$data3 = $conn->query($sql3);
$num = 0;
foreach ($data3 as $value) {
    $num++;
    $sno = $value['nc_id'];

    // คอลัมน์ตัวเลขลำดับ
    $pdf->Cell(8.1, 12, $num, 1, 0, 'C', 1);



    // คอลัมน์ชื่อ
    $pdf->Cell(38.8, 12, $value['nc_name'], 1, 0, 'L', 1);

    // คอลัมน์อายุ
    $pdf->Cell(10.3, 12, $value['nc_age'], 1, 0, 'C', 1);

    $pdf->SetFontSize(7.2);
    $pdf->Cell(42, 12, $value['nc_kammaban'], 1, 0, 'C', 0);


    $pdf->SetFontSize(9);
    $pdf->Cell(25.7, 12, $value['nc_lat'], 1, 0, 'C', 0);


    $pdf->SetFontSize(7.8);
    $pdf->Cell(23.5, 12, $value['nc_phak'], 1, 0, 'C', 0);


    $pdf->SetFontSize(9);
    $pdf->Cell(20.2, 12, $value['theory'], 1, 0, 'C', 0);

    // คอลัมน์ nc_reason
    $pdf->SetFontSize(9);
    $pdf->Cell(32.6, 12, $value['nc_part'], 1, 1, 'C', 1);
}


// Add notes and closing statements
$pdf->Ln(5);
$pdf->SetFontSize(10);
$pdf->SetFont('', 'BU');
$pdf->Cell(0, 8, 'ວິທີເລືອກ:', 0, 1, 'L');

$pdf->SetFontSize(10);
$pdf->SetFont('', '');
$pdf->MultiCell(0, 5, 'ໂດຍອີງຕາມມາດຕະຖານ ແລະ ເງື່ອນໄຂ ທີ່ກຳນົດ, ໃຫ້ຜູ້ແທນກອງປະຊຸມ:', 0, 'L', 0, 1);

$pdf->SetFontSize(10);
$pdf->SetFont('', '');
$pdf->MultiCell(0, 5, '- ຂີດອອກຈໍານວນ 4 ສະຫາຍ, ຂີດແຕ່ຕົວເລກລໍາດັບ ຈົນຮອດ ກົມ​ກອງ ແລະ ບໍ່ໃຫ້ເປື້ອນ.', 0, 'L', 0, 1);

$pdf->SetFontSize(10);
$pdf->SetFont('', '');
$pdf->MultiCell(0, 5, '- ຈົ່ງໄວ້ 23 ສະຫາຍ ທີ່ຕົນເອງເຫັນດີໃຫ້ເປັນຄະນະບໍລິຫານງານສະຫະພັນກໍາມະບານກະຊວງອຸດສາຫະກໍາ ແລະ ການຄ້າ(ຊຸດໃໝ່).', 0, 'L', 0, 1);


// Close and output the PDF document
$pdf->Output('export.pdf', 'I');
