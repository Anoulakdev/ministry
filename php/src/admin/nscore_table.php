<?php
include '../config.php';
$query = "SELECT sum(sc.nsc_result) as scres, nc.nc_id, nc.nc_name, nc.nc_age, nc.nc_part, nc.nc_pic FROM nscore as sc right join newcandidate as nc on sc.nc_id = nc.nc_id group by nc.nc_name order by scres DESC, nc.nc_id ASC";
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
            <th width="9%" class="fs-3">ລ/ດ</th>
            <th width="15%" class="fs-3">ຮູບ​ພາບ</th>
            <th width="26%" class="fs-3">ຊື່​ຜູ້​ສະ​ໝັກ</th>
            <th width="12%" class="fs-3">ອາ​ຍຸ</th>
            <th width="20%" class="fs-3">ບ່ອນ​ປະ​ຈຳ​ການ</th>
            <th width="18%" class="fs-3">​ຄະ​ແນນ</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        <?php $i = 1; ?>
        <?php foreach ($data as $row) { ?>
            <tr>
                <td class="text-center fs-4" width="9%"><?= $i++; ?></td>
                <td class="text-center" width="15%">
                    <?php if ($row['nc_pic'] != "") { ?>
                        <img src="../uploads/candidate/<?= $row['nc_pic']; ?>" width="75" height="80" class="rounded-circle">
                    <?php } else { ?>
                        <img src="../assets/img/profile-picture.jpg" alt="Profile" width="75" height="80" class="rounded-circle">
                    <?php } ?>
                </td>
                <td width="26%" class="fs-4"><?= $row['nc_name']; ?></td>
                <td width="12%" class="fs-4 text-center"><?= $row['nc_age']; ?></td>
                <td width="20%" class="fs-4 text-center"><?= $row['nc_part']; ?></td>
                <?php if ($row['scres']) { ?>
                    <td class="text-center fs-4 fw-bold" width="18%"><?= $row['scres']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-4 fw-bold" width="18%">0</td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <?php
        $query1 = "SELECT sum(nsc_result) as scres FROM nscore";
        $stmt1 = $conn->prepare($query1);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        ?>
        <?php while ($row1 = $result1->fetch_assoc()) { ?>
            <tr class="text-center align-middle" style="height: 80px;">
                <th colspan="5" class="fs-3">ລວມ​ຄະ​ແນນ​ທັງ​ໝົດ</th>
                <?php if ($row1['scres']) { ?>
                    <td class="text-center fs-3 fw-bold" width="15%"><?= $row1['scres']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-3 fw-bold" width="15%">0</td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tfoot>
</table>