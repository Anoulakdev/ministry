<?php
include '../config.php';
include '../candidatecounts.php';
$query = "SELECT sum(ns2.nsc2_result) as scres2, nc2.nc2_id, nc2.nc2_name FROM nscore2 as ns2 right join newcandidate2 as nc2 on ns2.nc2_id = nc2.nc2_id group by nc2.nc2_name order by scres2 DESC, nc2.nc2_id ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$sql10 = "SELECT count(DISTINCT s_no) as sno FROM oscore2";
$result10 = $conn->query($sql10);
$row10 = $result10->fetch_assoc();
$sno = $row10['sno'];

?>
<table class="table table-bordered" id="table2">
    <thead>
        <tr class="text-center align-middle" style="height: 80px;">
            <th class="fs-5">ລ/ດ</th>
            <th class="fs-5">ຊື່​ຜູ້​ສະ​ໝັກ</th>
            <th class="fs-5">​ຄະ​ແນນໄດ້</th>
            <th class="fs-5">​ຄະ​ແນນ​ເສຍ</th>
            <th class="fs-5">ສະ​ເລ່ຍ​ຄະ​ແນນ​ເສຍ</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        <?php $i = 1; ?>
        <?php foreach ($data as $row) { ?>
            <tr>
                <td class="text-center fs-6"><?= $i++; ?></td>
                <td class="fs-6"><?= $row['nc2_name']; ?></td>
                <?php if ($row['scres2']) { ?>
                    <td class="text-center fs-6 fw-bold"><?= $row['scres2']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-6 fw-bold">0</td>
                <?php } ?>

                <?php if ($row['scres2']) { ?>
                    <td class="text-center fs-6 fw-bold">
                        <?php $scres2 = $row['scres2'];
                        $tores = $sno - $scres2;
                        ?> <?= $tores; ?>
                    </td>
                <?php } else { ?>
                    <td class="text-center fs-6 fw-bold"><?= $sno; ?></td>
                <?php } ?>


                <?php if ($row['scres2']) { ?>
                    <td class="text-center fs-6 fw-bold"><?php $scres2 = $row['scres2'];
                                                            $tores2 = $sno - $scres2;
                                                            $percent = ($tores2 / $sno) * 100;
                                                            ?> <?= number_format($percent, 2); ?> %</td>
                <?php } else { ?>
                    <td class="text-center fs-6 fw-bold"><?php if ($sno) {
                                                                $scres2 = $row['scres2'];
                                                                $tores2 = $sno - $scres2;
                                                                $percent = ($tores2 / $sno) * 100;
                                                            } else {
                                                                $percent = '0.00';
                                                            } ?> <?= number_format($percent, 2); ?> %</td>
                <?php } ?>


            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <?php
        $query1 = "SELECT sum(nsc2_result) as scres2 FROM nscore2";
        $stmt1 = $conn->prepare($query1);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        ?>
        <?php while ($row1 = $result1->fetch_assoc()) { ?>
            <tr class="text-center align-middle">
                <th colspan="2" class="fs-5">ລວມ​ຄະ​ແນນ​ທັງ​ໝົດ</th>
                <?php if ($row1['scres2']) { ?>
                    <td class="text-center fs-5 fw-bold" width="9%"><?= $row1['scres2']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-5 fw-bold" width="9%">0</td>
                <?php } ?>

                <?php if ($row1['scres2']) { ?>
                    <td class="text-center fs-5 fw-bold" width="9%"><?php $scres2 = $row1['scres2'];
                                                                    $multi = $sno * $cnc2;
                                                                    $tores2 = $multi - $scres2;
                                                                    ?> <?= $tores2; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-5 fw-bold" width="9%">0</td>
                <?php } ?>
                <td class="text-center fs-5 fw-bold" width="13%"></td>
            </tr>
        <?php } ?>
    </tfoot>
</table>