<?php
include '../config.php';
include '../candidatecounts.php';
$query = "SELECT sum(osc2.osc2_result) as sores2, count(osc2.osc2_id) - sum(osc2.osc2_result) as tores2, oc2.oc2_id, oc2.oc2_name FROM oscore2 as osc2 right join oldcandidate2 as oc2 on osc2.oc2_id = oc2.oc2_id group by oc2.oc2_name order by oc2.oc2_id ASC";
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
<table class="table table-bordered" id="table1">
    <thead>
        <tr class="text-center align-middle" style="height: 80px;">
            <th class="fs-5">ລ/ດ</th>
            <th class="fs-5">ຊື່​ຜູ້​ສະ​ໝັກ</th>
            <th class="fs-5">ເຫັນ​ດີ</th>
            <th class="fs-5">ບໍ່ເຫັນ​ດີ</th>
            <th class="fs-5">ສະ​ເລ່ຍ​ຄະ​ແນນ​ເສຍ</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        <?php $i = 1; ?>
        <?php foreach ($data as $row) { ?>
            <tr>
                <td class="text-center fs-6"><?= $i++; ?></td>
                <td class="fs-6"><?= $row['oc2_name']; ?></td>
                <?php if ($row['sores2']) { ?>
                    <td class="text-center fs-6 fw-bold"><?= $row['sores2']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-6 fw-bold">0</td>
                <?php } ?>

                <?php if ($row['tores2']) { ?>
                    <td class="text-center fs-6 fw-bold"><?= $row['tores2']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-6 fw-bold">0</td>
                <?php } ?>

                <?php if ($row['sores2']) { ?>
                    <td class="text-center fs-6 fw-bold"><?php $sores2 = $row['sores2'];
                                                            $tores2 = $sno - $sores2;
                                                            $percent = ($tores2 / $sno) * 100;
                                                            ?> <?= number_format($percent, 2); ?> %</td>
                <?php } else { ?>
                    <td class="text-center fs-6 fw-bold"><?php if ($sno) {
                                                                $sores2 = $row['sores2'];
                                                                $tores2 = $sno - $sores2;
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
        $query1 = "SELECT sum(osc2_result) as sores2, count(osc2_id) - sum(osc2_result) as tores2 FROM oscore2";
        $stmt1 = $conn->prepare($query1);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        ?>
        <?php while ($row1 = $result1->fetch_assoc()) { ?>
            <tr class="text-center align-middle">
                <th colspan="2" class="fs-5">ລວມ​ຄະ​ແນນ​ທັງ​ໝົດ</th>
                <?php if ($row1['sores2']) { ?>
                    <td class="text-center fs-5 fw-bold"><?= $row1['sores2']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-5 fw-bold">0</td>
                <?php } ?>

                <?php if ($row1['tores2']) { ?>
                    <td class="text-center fs-5 fw-bold"><?= $row1['tores2']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-5 fw-bold">0</td>
                <?php } ?>
                <td class="text-center fs-5 fw-bold" width="13%"></td>
            </tr>
        <?php } ?>
    </tfoot>
</table>