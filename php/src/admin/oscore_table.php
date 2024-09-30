<?php
include '../config.php';
$query = "SELECT count(DISTINCT m_id) as cmid, sum(osc.osc_result) as sores, count(osc.osc_id) - sum(osc.osc_result) as tores, oc.oc_id, oc.oc_name, oc.oc_age, oc.oc_part, oc.oc_pic FROM oscore as osc right join oldcandidate as oc on osc.oc_id = oc.oc_id group by oc.oc_name order by oc.oc_id ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
?>
<table class="table table-bordered" id="table">
    <thead>
        <tr class="text-center align-middle" style="height: 80px;">
            <th width="8%" class="fs-3">ລ/ດ</th>
            <th width="12%" class="fs-3">ຮູບ​ພາບ</th>
            <th width="24%" class="fs-3">ຊື່​ຜູ້​ສະ​ໝັກ</th>
            <th width="9%" class="fs-3">ອາ​ຍຸ</th>
            <th width="16%" class="fs-3">ບ່ອນ​ປະ​ຈຳ​ການ</th>
            <th width="9%" class="fs-3">ສືບ​ຕໍ່</th>
            <th width="9%" class="fs-3">ບໍ່ສືບ​ຕໍ່</th>
            <th width="13%" class="fs-3">ສະ​ເລ່ຍ​ຄະ​ແນນ​ເສຍ</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        <?php $i = 1; ?>
        <?php foreach ($data as $row) { ?>
            <tr>
                <td class="text-center fs-4" width="8%"><?= $i++; ?></td>
                <td class="text-center" width="12%">
                    <?php if ($row['oc_pic'] != "") { ?>
                        <img src="../uploads/candidate/<?= $row['oc_pic']; ?>" width="75" height="80" class="rounded-circle">
                    <?php } else { ?>
                        <img src="../assets/img/profile-picture.jpg" alt="Profile" width="75" height="80" class="rounded-circle">
                    <?php } ?>
                </td>
                <td width="24%" class="fs-4"><?= $row['oc_name']; ?></td>
                <td width="9%" class="fs-4 text-center"><?= $row['oc_age']; ?></td>
                <td width="16%" class="fs-4 text-center"><?= $row['oc_part']; ?></td>
                <?php if ($row['sores']) { ?>
                    <td class="text-center fs-4 fw-bold" width="9%"><?= $row['sores']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-4 fw-bold" width="9%">0</td>
                <?php } ?>

                <?php if ($row['tores']) { ?>
                    <td class="text-center fs-4 fw-bold" width="9%"><?= $row['tores']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-4 fw-bold" width="9%">0</td>
                <?php } ?>
                <td width="13%" class="fs-4 text-center fw-bold">
                    <?php $cmid = $row['cmid'];
                    $not = $row['tores'];
                    $percent = ($not / $cmid) * 100;
                    ?> <?= number_format($percent, 2); ?> %</td>
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
                <th colspan="5" class="fs-3">ລວມ​ຄະ​ແນນ​ທັງ​ໝົດ</th>
                <?php if ($row1['sores']) { ?>
                    <td class="text-center fs-3 fw-bold" width="9%"><?= $row1['sores']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-3 fw-bold" width="9%">0</td>
                <?php } ?>

                <?php if ($row1['tores']) { ?>
                    <td class="text-center fs-3 fw-bold" width="9%"><?= $row1['tores']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-3 fw-bold" width="9%">0</td>
                <?php } ?>
                <td class="text-center fs-3 fw-bold" width="13%"></td>
            </tr>
        <?php } ?>
    </tfoot>
</table>