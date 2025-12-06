<?php
include '../config.php';
include '../candidatecounts.php';
$query = "SELECT sum(ns1.nsc1_result) as scres1, nc1.nc1_id, nc1.nc1_name FROM nscore1 as ns1 right join newcandidate1 as nc1 on ns1.nc1_id = nc1.nc1_id group by nc1.nc1_name order by scres1 DESC, nc1.nc1_id ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$sql10 = "SELECT count(DISTINCT s_no) as sno FROM oscore1";
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
                <td class="fs-6"><?= $row['nc1_name']; ?></td>
                <?php if ($row['scres1']) { ?>
                    <td class="text-center fs-6 fw-bold"><?= $row['scres1']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-6 fw-bold">0</td>
                <?php } ?>

                <?php if ($row['scres1']) { ?>
                    <td class="text-center fs-6 fw-bold">
                        <?php $scres1 = $row['scres1'];
                        $tores = $sno - $scres1;
                        ?> <?= $tores; ?>
                    </td>
                <?php } else { ?>
                    <td class="text-center fs-6 fw-bold"><?= $sno; ?></td>
                <?php } ?>


                <?php if ($row['scres1']) { ?>
                    <td class="text-center fs-6 fw-bold"><?php $scres1 = $row['scres1'];
                                                            $tores1 = $sno - $scres1;
                                                            $percent = ($tores1 / $sno) * 100;
                                                            ?> <?= number_format($percent, 2); ?> %</td>
                <?php } else { ?>
                    <td class="text-center fs-6 fw-bold"><?php if ($sno) {
                                                                $scres1 = $row['scres1'];
                                                                $tores1 = $sno - $scres1;
                                                                $percent = ($tores1 / $sno) * 100;
                                                            } else {
                                                                $percent = '0.00';
                                                            } ?> <?= number_format($percent, 2); ?> %</td>
                <?php } ?>


            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <?php
        $query1 = "SELECT sum(nsc1_result) as scres1 FROM nscore1";
        $stmt1 = $conn->prepare($query1);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        ?>
        <?php while ($row1 = $result1->fetch_assoc()) { ?>
            <tr class="text-center align-middle">
                <th colspan="2" class="fs-5">ລວມ​ຄະ​ແນນ​ທັງ​ໝົດ</th>
                <?php if ($row1['scres1']) { ?>
                    <td class="text-center fs-5 fw-bold" width="9%"><?= $row1['scres1']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-5 fw-bold" width="9%">0</td>
                <?php } ?>

                <?php if ($row1['scres1']) { ?>
                    <td class="text-center fs-5 fw-bold" width="9%"><?php $scres1 = $row1['scres1'];
                                                                    $multi = $sno * $cnc1;
                                                                    $tores1 = $multi - $scres1;
                                                                    ?> <?= $tores1; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-5 fw-bold" width="9%">0</td>
                <?php } ?>
                <td class="text-center fs-5 fw-bold" width="13%"></td>
            </tr>
        <?php } ?>
    </tfoot>
</table>