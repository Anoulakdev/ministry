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
            <th rowspan="2" width="7%" style="text-align:center; vertical-align:middle;">ຮູບ​ພາບ</th>
            <th rowspan="2" width="20%" style="text-align:center; vertical-align:middle;">​ຊື່ ແລະ ນາມ​ສະ​ກຸນ</th>
            <th rowspan="2" width="4%" style="text-align:center; vertical-align:middle;">​ອາ​ຍຸ</th>
            <th colspan="3" width="34%" style="text-align:center; vertical-align:middle;">ຕຳ​ແໜ່ງ</th>
            <th rowspan="2" width="13%" style="text-align:center; vertical-align:middle;">ກົມ​ກອງ​ບ່ອນ​ປະ​ຈຳ​ການ</th>
            <th rowspan="2" width="18%" style="text-align:center; vertical-align:middle;">barcode</th>
        </tr>
        <tr>
            <th width="13%" style="text-align:center; vertical-align:middle;">​ຊາ​ວ​ໜຸ່ມ</th>
            <th width="9%" style="text-align:center; vertical-align:middle;">​ລັດ</th>
            <th width="12%" style="text-align:center; vertical-align:middle;">ພັກ</th>
        </tr>';
$html .= '</table>';

// Create new PDF document
$pdf = new TCPDF("P", "mm", "A4", true, 'UTF-8', false);
$pdf->SetMargins(3, 3, 3);
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
$pdf->Cell(67, 10, 'ບັດ', 0, 0, 'C');
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

$pdf->SetFontSize(12);
$pdf->SetFont('', 'B');
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 10, 'ບຸກ​ຄະ​ລາ​ກອນ​ລົງ​ສະ​ໝັກ​ຮັບ​ເລືອກ​ຕັ້ງ ເປັນ​ຄະ​ນະ​ບໍ​ລິ​ຫານ​ງານ ຊ​ປ​ປ​ລ ກະ​ຊວງ​ພະ​ລັງ​ງານ ແລະ ບໍ່​ແຮ່ ຊຸດ​ທີ IV', 0, 1, 'C');

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

    $pdf->Cell(8.1, 16, $num, 1, 0, 'C', 1);
    $pdf->Cell(0.1, 16, '', 1, 0, 'C', 0);
    $pdf->Image('../uploads/candidate/' . $value['nc_pic'], '', '', 14, '', '', 'C', '', false, 300, '', false, false, 1, false, false, false);
    $pdf->Cell(14.1, 16, '', 0, 0, 'C', 0);
    $pdf->Cell(41, 16, $value['nc_name'], 1, 0, 'L', 1);
    $pdf->Cell(8, 16, $value['nc_age'], 1, 0, 'C', 1);
    $pdf->WriteHTMLCell(26.6, 16, '', '', $value['nc_saonoum'], 1, 0, 'C', 1);
    $pdf->WriteHTMLCell(18.4, 16, '', '', $value['nc_lat'], 1, 0, 'C', 1);
    $pdf->MultiCell(24.5, 16, $value['nc_phak'], 1, 'C', 1, 0);
    $pdf->WriteHTMLCell(26.5, 16, '', '', $value['nc_part'], 1, 0, 'C', 1);
    $pdf->write1DBarcode($sno, 'C128', '', '', '', 16, 0.6, array(
        'position' => 'R',
        'align' => 'B',
        'stretch' => true,
        'fitwidth' => true,
        'border' => true,
        'hpadding' => 'auto',
        'vpadding' => 'auto',
        'fgcolor' => array(0, 0, 0),
        'bgcolor' => false,
        'text' => true,
        'font' => 'phetsarath_ot',
        'fontsize' => 4,
        'stretchtext' => 12,
    ), 'N');
}

// Add notes and closing statements
$pdf->Ln(5);
$pdf->SetFontSize(10);
$pdf->SetFont('', 'BU');
$pdf->Cell(0, 8, 'ໜາຍ​ເຫດ​ຄຳ​ແນ​ະ​ນຳ:', 0, 1, 'L');

$pdf->SetFontSize(10);
$pdf->SetFont('', '');
$pdf->MultiCell(0, 10, '1. ຈຳນວນຜູ້ລົງສະໝັກເລືອກຕັ້ງເປັນຄະນະບໍລິຫານງານ ຊປປລ ກະຊວງພະລັງງານ ແລະ ບໍ່ແຮ່ ສະ​ໄໝ​ທີ IV ມີທັງໝົດ 28 ສະຫາຍ ເພື່ອ​ຄັດ​ເລືອກ 25 ສະ​ຫາຍ ເປັນ​ຄະ​ນະ​ບໍ​ລິ​ຫານ​ງານ ຊ​ປ​ປ​ລ ກະ​ຊວງ​ພະ​ລັງ​ງານ ແລະ ບໍ່​ແຮ່ ຊຸດ​ທີ IV.', 0, 'L', 0, 1);

$pdf->SetFontSize(10);
$pdf->SetFont('', '');
$pdf->MultiCell(0, 5, '2. ວິ​ທີ​ຈັດ​ຕັ້ງ​ປະ​ຕິ​ບັ​ດ: ໃຫ້​ຂີດ​ອອກ 3 ສະ​ຫາຍ ຈາກ 28 ສະ​ຫາຍ ຜູ້​ທີ່​ຕົນ​ເອງ​ບໍ່​ເລືອກ​ເອົາ ແລະ ໃຫ້​ຂີດ​ນັບ​ແຕ່​ຫ້ອງ ລຳ​ດັບ ຈົນ​ຮອດ​ຫ້ອງ​ກົມ​ກອງ.', 0, 'L', 0, 1);

$pdf->SetFontSize(10);
$pdf->SetFont('', '');
$pdf->MultiCell(0, 0, '3. ​ບັດ​ໃດ ທີ່​ບໍ່​ໄດ້​ປະ​ຕິ​ບັດ​ຕາມ​ຄຳ​ແນະ​ນຳ​ໝາຍ​ເຫດ​ຂໍ້ 2 ແລະ 3 ຂອງ​ບັດ​ເລືອກ​ຕັ້ງ​ສະ​ບັບ​ນີ້ ຖື​ວ່າ​ເປັນ​ບັດ​ຕາຍ ຫຼື ບໍ່​ສາ​ມາດ​ນຳ​ມາ​ນັບ​ຄະ​ແນນ​ໄດ້.', 0, 'L', 0, 1);

// Close and output the PDF document
$pdf->Output('export.pdf', 'I');
