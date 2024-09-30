<?php
include '../config.php';
$query = "SELECT count(DISTINCT m_id) as cmid, count(sc.nc_id) - sum(sc.nsc_result) as tores, sum(sc.nsc_result) as scres, nc.nc_id, nc.nc_name, nc.nc_age, nc.nc_part, nc.nc_pic FROM nscore as sc right join newcandidate as nc on sc.nc_id = nc.nc_id group by nc.nc_name order by scres DESC, nc.nc_id ASC";
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
            <th width="9%" class="fs-3">​ຄະ​ແນນໄດ້</th>
            <th width="9%" class="fs-3">​ຄະ​ແນນ​ເສຍ</th>
            <th width="13%" class="fs-3">ສະ​ເລ່ຍ​ຄະ​ແນນ​ເສຍ</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        <?php $i = 1; ?>
        <?php foreach ($data as $row) { ?>
            <tr>
                <td class="text-center fs-4" width="8%"><?= $i++; ?></td>
                <td class="text-center" width="12%">
                    <?php if ($row['nc_pic'] != "") { ?>
                        <img src="../uploads/candidate/<?= $row['nc_pic']; ?>" width="75" height="80" class="rounded-circle">
                    <?php } else { ?>
                        <img src="../assets/img/profile-picture.jpg" alt="Profile" width="75" height="80" class="rounded-circle">
                    <?php } ?>
                </td>
                <td width="24%" class="fs-4"><?= $row['nc_name']; ?></td>
                <td width="9%" class="fs-4 text-center"><?= $row['nc_age']; ?></td>
                <td width="16%" class="fs-4 text-center"><?= $row['nc_part']; ?></td>
                <?php if ($row['scres']) { ?>
                    <td class="text-center fs-4 fw-bold" width="9%"><?= $row['scres']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-4 fw-bold" width="9%">0</td>
                <?php } ?>

                <?php if ($row['tores']) { ?>
                    <td class="text-center fs-4 fw-bold" width="9%"><?= $row['tores']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-4 fw-bold" width="9%">0</td>
                <?php } ?>

               
                <?php if ($row['cmid']) { ?>
                    <td class="text-center fs-4 fw-bold" width="13%"><?php $cmid = $row['cmid'];
                    $not = $row['tores'];
                    $percent = ($not / $cmid) * 100;
                    ?> <?= number_format($percent, 2); ?> %</td>
                <?php } else { ?>
                    <td class="text-center fs-4 fw-bold" width="13%">0.00 %</td>
                <?php } ?>

                
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <?php
        $query1 = "SELECT sum(nsc_result) as scres, count(nc_id) - sum(nsc_result) as tores FROM nscore";
        $stmt1 = $conn->prepare($query1);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        ?>
        <?php while ($row1 = $result1->fetch_assoc()) { ?>
            <tr class="text-center align-middle" style="height: 80px;">
                <th colspan="5" class="fs-3">ລວມ​ຄະ​ແນນ​ທັງ​ໝົດ</th>
                <?php if ($row1['scres']) { ?>
                    <td class="text-center fs-3 fw-bold" width="9%"><?= $row1['scres']; ?></td>
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