<?php
include '../config.php';
include '../candidatecounts.php';
$query = "SELECT sum(sc.nsc_result) as scres, nc.nc_id, nc.nc_name, nc.nc_pic FROM nscore as sc right join newcandidate as nc on sc.nc_id = nc.nc_id group by nc.nc_name order by scres DESC, nc.nc_id ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$sql10 = "SELECT count(DISTINCT s_no) as sno FROM nscore";
$result10 = $conn->query($sql10);
$row10 = $result10->fetch_assoc();
$sno = $row10['sno'];

?>
<table class="table table-bordered" id="table">
    <thead>
        <tr class="text-center align-middle" style="height: 80px;">
            <th width="8%" class="fs-3">ລ/ດ</th>
            <!-- <th width="12%" class="fs-3">ຮູບ​ພາບ</th> -->
            <th width="24%" class="fs-3">ຊື່​ຜູ້​ສະ​ໝັກ</th>
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
                <!-- <td class="text-center" width="12%">
                    <?php if ($row['nc_pic'] != "") { ?>
                        <img src="../uploads/candidate/<?= $row['nc_pic']; ?>" width="75" height="80" class="rounded-circle">
                    <?php } else { ?>
                        <img src="../assets/img/profile-picture.jpg" alt="Profile" width="75" height="80" class="rounded-circle">
                    <?php } ?>
                </td> -->
                <td width="24%" class="fs-4"><?= $row['nc_name']; ?></td>
                <?php if ($row['scres']) { ?>
                    <td class="text-center fs-4 fw-bold" width="9%"><?= $row['scres']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-4 fw-bold" width="9%">0</td>
                <?php } ?>

                <?php if ($row['scres']) { ?>
                    <td class="text-center fs-4 fw-bold" width="9%">
                        <?php $scres = $row['scres'];
                        $tores = $sno - $scres;
                        ?> <?= $tores; ?>
                    </td>
                <?php } else { ?>
                    <td class="text-center fs-4 fw-bold" width="9%"><?= $sno; ?></td>
                <?php } ?>


                <?php if ($row['scres']) { ?>
                    <td class="text-center fs-4 fw-bold" width="13%"><?php $scres = $row['scres'];
                                                                        $tores = $sno - $scres;
                                                                        $percent = ($tores / $sno) * 100;
                                                                        ?> <?= number_format($percent, 2); ?> %</td>
                <?php } else { ?>
                    <td class="text-center fs-4 fw-bold" width="13%"><?php if ($sno) {
                                                                            $scres = $row['scres'];
                                                                            $tores = $sno - $scres;
                                                                            $percent = ($tores / $sno) * 100;
                                                                        } else {
                                                                            $percent = '0.00';
                                                                        } ?> <?= number_format($percent, 2); ?> %</td>
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
                <th colspan="2" class="fs-3">ລວມ​ຄະ​ແນນ​ທັງ​ໝົດ</th>
                <?php if ($row1['scres']) { ?>
                    <td class="text-center fs-3 fw-bold" width="9%"><?= $row1['scres']; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-3 fw-bold" width="9%">0</td>
                <?php } ?>

                <?php if ($row1['scres']) { ?>
                    <td class="text-center fs-3 fw-bold" width="9%"><?php $scres = $row1['scres'];
                                                                    $multi = $sno * $cnc;
                                                                    $tores = $multi - $scres;
                                                                    ?> <?= $tores; ?></td>
                <?php } else { ?>
                    <td class="text-center fs-3 fw-bold" width="9%">0</td>
                <?php } ?>
                <td class="text-center fs-3 fw-bold" width="13%"></td>
            </tr>
        <?php } ?>
    </tfoot>
</table>