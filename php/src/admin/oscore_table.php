<?php
include '../config.php';
$query = "SELECT sum(osc.osc_result) as sores, count(osc.osc_id) - sum(osc.osc_result) as tores, oc.oc_id, oc.oc_name, oc.oc_age, oc.oc_part FROM oscore as osc right join oldcandidate as oc on osc.oc_id = oc.oc_id group by oc.oc_name order by oc.oc_id ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$sql10 = "SELECT count(DISTINCT m_id) as mid FROM oscore";
$result10 = $conn->query($sql10);
$row10 = $result10->fetch_assoc();
$mid = $row10['mid'];

?>
<table class="table table-bordered" id="table">
    <thead>
        <tr class="text-center align-middle" style="height: 80px;">
            <th class="fs-3">ລ/ດ</th>
            <th class="fs-3">ຊື່​ຜູ້​ສະ​ໝັກ</th>
            <th class="fs-3">ອາ​ຍຸ</th>
            <th class="fs-3">ບ່ອນ​ປະ​ຈຳ​ການ</th>
            <th class="fs-3">ສືບ​ຕໍ່</th>
            <th class="fs-3">ບໍ່ສືບ​ຕໍ່</th>
            <th class="fs-3">ສະ​ເລ່ຍ​ຄະ​ແນນ​ເສຍ</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        <?php $i = 1; ?>
        <?php foreach ($data as $row) { ?>
            <tr>
                <td class="text-center fs-4"><?= $i++; ?></td>
                <td class="fs-4"><?= $row['oc_name']; ?></td>
                <td class="fs-4 text-center"><?= $row['oc_age']; ?></td>
                <td class="fs-4 text-center"><?= $row['oc_part']; ?></td>
                <?php if ($row['sores']) { ?>
                    <td class="text-center fs-4 fw-bold"><?= $row['sores']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-4 fw-bold">0</td>
                <?php } ?>

                <?php if ($row['tores']) { ?>
                    <td class="text-center fs-4 fw-bold"><?= $row['tores']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-4 fw-bold">0</td>
                <?php } ?>

                <?php if ($row['sores']) { ?>
                    <td class="text-center fs-4 fw-bold" width="13%"><?php $sores = $row['sores'];
                                                                        $tores = $mid - $sores;
                                                                        $percent = ($tores / $mid) * 100;
                                                                        ?> <?= number_format($percent, 2); ?> %</td>
                <?php } else { ?>
                    <td class="text-center fs-4 fw-bold" width="13%"><?php if ($mid) {
                                                                            $sores = $row['sores'];
                                                                            $tores = $mid - $sores;
                                                                            $percent = ($tores / $mid) * 100;
                                                                        } else {
                                                                            $percent = '0.00';
                                                                        } ?> <?= number_format($percent, 2); ?> %</td>
                <?php } ?>

            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <?php
        $query1 = "SELECT sum(osc_result) as sores, count(osc_id) - sum(osc_result) as tores FROM oscore";
        $stmt1 = $conn->prepare($query1);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        ?>
        <?php while ($row1 = $result1->fetch_assoc()) { ?>
            <tr class="text-center align-middle" style="height: 80px;">
                <th colspan="4" class="fs-3">ລວມ​ຄະ​ແນນ​ທັງ​ໝົດ</th>
                <?php if ($row1['sores']) { ?>
                    <td class="text-center fs-3 fw-bold"><?= $row1['sores']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-3 fw-bold">0</td>
                <?php } ?>

                <?php if ($row1['tores']) { ?>
                    <td class="text-center fs-3 fw-bold"><?= $row1['tores']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-3 fw-bold">0</td>
                <?php } ?>
                <td class="text-center fs-3 fw-bold"></td>
            </tr>
        <?php } ?>
    </tfoot>
</table>