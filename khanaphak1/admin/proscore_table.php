<?php
include '../config.php';
include '../candidatecounts.php';
$query = "SELECT sum(osc1.osc1_result) as sores1, count(osc1.osc1_id) - sum(osc1.osc1_result) as tores1, oc1.oc1_id, oc1.oc1_name FROM oscore1 as osc1 right join oldcandidate1 as oc1 on osc1.oc1_id = oc1.oc1_id group by oc1.oc1_name order by oc1.oc1_id ASC";
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
<table class="table table-bordered" id="table1">
    <thead>
        <tr class="text-center align-middle" style="height: 80px;">
            <th class="fs-5">ລ/ດ</th>
            <th class="fs-5">ຊື່​ຜູ້​ສະ​ໝັກ</th>
            <th class="fs-5">ສືບ​ຕໍ່</th>
            <th class="fs-5">ບໍ່ສືບ​ຕໍ່</th>
            <th class="fs-5">ສະ​ເລ່ຍ​ຄະ​ແນນ​ເສຍ</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        <?php $i = 1; ?>
        <?php foreach ($data as $row) { ?>
            <tr>
                <td class="text-center fs-6"><?= $i++; ?></td>
                <td class="fs-6"><?= $row['oc1_name']; ?></td>
                <?php if ($row['sores1']) { ?>
                    <td class="text-center fs-6 fw-bold"><?= $row['sores1']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-6 fw-bold">0</td>
                <?php } ?>

                <?php if ($row['tores1']) { ?>
                    <td class="text-center fs-6 fw-bold"><?= $row['tores1']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-6 fw-bold">0</td>
                <?php } ?>

                <?php if ($row['sores1']) { ?>
                    <td class="text-center fs-6 fw-bold"><?php $sores1 = $row['sores1'];
                                                            $tores1 = $sno - $sores1;
                                                            $percent = ($tores1 / $sno) * 100;
                                                            ?> <?= number_format($percent, 2); ?> %</td>
                <?php } else { ?>
                    <td class="text-center fs-6 fw-bold"><?php if ($sno) {
                                                                $sores1 = $row['sores1'];
                                                                $tores1 = $sno - $sores1;
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
        $query1 = "SELECT sum(osc1_result) as sores1, count(osc1_id) - sum(osc1_result) as tores1 FROM oscore1";
        $stmt1 = $conn->prepare($query1);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        ?>
        <?php while ($row1 = $result1->fetch_assoc()) { ?>
            <tr class="text-center align-middle">
                <th colspan="2" class="fs-5">ລວມ​ຄະ​ແນນ​ທັງ​ໝົດ</th>
                <?php if ($row1['sores1']) { ?>
                    <td class="text-center fs-5 fw-bold"><?= $row1['sores1']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-5 fw-bold">0</td>
                <?php } ?>

                <?php if ($row1['tores1']) { ?>
                    <td class="text-center fs-5 fw-bold"><?= $row1['tores1']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-5 fw-bold">0</td>
                <?php } ?>
                <td class="text-center fs-5 fw-bold" width="13%"></td>
            </tr>
        <?php } ?>
    </tfoot>
</table>