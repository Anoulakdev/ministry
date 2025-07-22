<?php
require_once('../tcpdf/tcpdf.php');
include '../config.php';

if (isset($_POST)) {
    $page1 = $_POST['page1'];
    $page2 = $_POST['page2'];
} else {
    echo "Error: No data received.";
}
// Retrieve data from the database
$sql = "SELECT * FROM sheet WHERE s_id BETWEEN '$page1' AND '$page2'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$html = '<table border="1" cellpadding="4" width="100%">';
$html .= '<tr>
            <th rowspan="2" width="4%" style="text-align:center; vertical-align:middle;">ລ/ດ</th>
            <th rowspan="2" width="7%" style="text-align:center; vertical-align:middle;">ຮູບ​ພາບ</th>
            <th rowspan="2" width="19%" style="text-align:center; vertical-align:middle;">​ຊື່ ແລະ ນາມ​ສະ​ກຸນ</th>
            <th rowspan="2" width="6%" style="text-align:center; vertical-align:middle;">ຊົນ​ເຜົ່າ</th>
            <th rowspan="2" width="5%" style="text-align:center; vertical-align:middle;">​ອາ​ຍຸ</th>
            <th colspan="3" width="34%" style="text-align:center; vertical-align:middle;">ຕຳ​ແໜ່ງ</th>
            <th rowspan="2" width="17.1%" style="text-align:center; vertical-align:middle;">ກົມ​ກອງ​ບ່ອນ​ປະ​ຈຳ​ການ</th>
            <th rowspan="2" width="7.2%" style="text-align:center; vertical-align:middle;">ລະ​ດັບ​​ວິ​ຊາ​ສະ​ເພາະ</th>
        </tr>
        <tr>
            <th width="12.2%" style="text-align:center; vertical-align:middle;">ແມ່​ຍິງ</th>
            <th width="12.6%" style="text-align:center; vertical-align:middle;">​ລັດ</th>
            <th width="9.2%" style="text-align:center; vertical-align:middle;">ພັກ</th>
        </tr>';
$html .= '</table>';

// Create new PDF document
$pdf = new TCPDF("P", "mm", "A4", true, 'UTF-8', false);
$pdf->SetMargins(4, 6, 2);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(true, 0);

// Add a new page
foreach ($data as $row) {
    $pdf->AddPage();

    $s_no = $row['s_no'];
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
    $pdf->Cell(0, 10, 'ເປົ້າ​ໝາຍ​ລົງ​ສະ​ໝັກເລືອກ​ຕັ້ງ ຄະນະບໍລິຫານງານສະຫະພັນແມ່ຍິງກະຊວງ ພະລັງງານ ແລະ ບໍ່ແຮ່ ສະ​ໄໝ​ທີ IV', 0, 1, 'C');

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
        $pdf->Cell(8.1, 16, $num, 1, 0, 'C', 1);

        // คอลัมน์รูปภาพ
        $pdf->Image('../uploads/candidate/' . $value['nc_pic'], '', '', 14.3, 16, '', '', '', false, 300, '', false, false, 1, false, false, false);
        $pdf->Cell(14.3, 16, '', 0, 0, 'C', 0);

        // คอลัมน์ชื่อ
        $pdf->Cell(38.8, 16, $value['nc_name'], 1, 0, 'L', 1);

        // คอลัมน์เผ่า
        $pdf->Cell(12.2, 16, $value['tribe'], 1, 0, 'C', 1);

        // คอลัมน์อายุ
        $pdf->Cell(10.1, 16, $value['nc_age'], 1, 0, 'C', 1);

        if (strlen($value['nc_women']) > 70) {
            $pdf->SetFontSize(8.2);
            $pdf->MultiCell(25, 16, $value['nc_women'], 1, 'C', 1, 0);
        } else {
            $pdf->SetFontSize(8.2);
            $pdf->Cell(25, 16, $value['nc_women'], 1, 0, 'C', 0);
        }

        $pdf->SetFontSize(9);
        $pdf->Cell(25.7, 16, $value['nc_lat'], 1, 0, 'C', 0);

        if (strlen($value['nc_phak']) > 35) {
            $pdf->SetFontSize(8.8);
            $pdf->MultiCell(18.8, 16, $value['nc_phak'], 1, 'C', 1, 0);
        } else {
            $pdf->SetFontSize(8.8);
            $pdf->Cell(18.8, 16, $value['nc_phak'], 1, 0, 'C', 0);
        }

        $pdf->SetFontSize(7);
        $pdf->Cell(35, 16, $value['nc_part'], 1, 0, 'C', 0);

        // คอลัมน์ nc_reason
        $pdf->SetFontSize(9);
        $pdf->Cell(14.3, 16, $value['nc_reason'], 1, 1, 'C', 1);
    }


    // Add notes and closing statements
    $pdf->Ln(5);
    $pdf->SetFontSize(10);
    $pdf->SetFont('', 'BU');
    $pdf->Cell(0, 8, 'ໜາຍ​ເຫດ​ຄຳ​ແນ​ະ​ນຳ:', 0, 1, 'L');

    $pdf->SetFontSize(10);
    $pdf->SetFont('', '');
    $pdf->MultiCell(0, 10, '1. ຈຳນວນຜູ້ລົງສະໝັກເລືອກຕັ້ງເປັນຄະນະບໍລິຫານງານ ສະ​ຫະ​ພັນ​ແມ່​ຍິງ ກະຊວງພະລັງງານ ແລະ ບໍ່ແຮ່ ສະ​ໄໝ​ທີ IV ມີທັງໝົດ 20 ສະຫາຍ ເພື່ອ​ຄັດ​ເລືອກເອົາ 17 ສະ​ຫາຍ ເປັນ​ຄະ​ນະ​ບໍ​ລິ​ຫານ​ງານ ສະ​ຫະ​ພັນ​ແມ່​ຍິງ ກະ​ຊວງ​ພະ​ລັງ​ງານ ແລະ ບໍ່​ແຮ່ ຊຸດ​ທີ IV.', 0, 'L', 0, 1);

    $pdf->SetFontSize(10);
    $pdf->SetFont('', '');
    $pdf->MultiCell(0, 5, '2. ວິ​ທີ​ຈັດ​ຕັ້ງ​ປະ​ຕິ​ບັ​ດ: ໃຫ້​ຂີດ​ອອກ 3 ສະ​ຫາຍ ຈາກ 20 ສະ​ຫາຍ ຜູ້​ທີ່​ຕົນ​ເອງ​ບໍ່​ເລືອກ​ເອົາ ແລະ ໃຫ້​ຂີດ​ນັບ​ແຕ່​ຫ້ອງ ລຳ​ດັບ ຈົນ​ຮອດ​ຫ້ອງ ລະ​ດັບ​​ວິ​ຊາ​ສະ​ເພາະ.', 0, 'L', 0, 1);
    // Close and output the PDF document
}
$pdf->Output('export.pdf', 'I');
