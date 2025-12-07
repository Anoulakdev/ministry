<?php
include 's_action.php';
include '../kill.php';
$sql12 = "SELECT s_no FROM sheet order by s_id DESC LIMIT 1";
$result12 = $conn->query($sql12);
$row12 = $result12->fetch_assoc();

$length = isset($row12['s_no']) ? strlen($row12['s_no']) : 0;

$query = "SELECT * FROM newcandidate";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// ปิด resource
$result->free();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ລົງ​ຄະ​ແນນ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include '../style/stylesheet.php'; ?>


</head>

<body class="toggle-sidebar">

    <!-- ======= Header ======= -->
    <?php include '../navbar/navbar_m.php'; ?>

    <!-- ======= Sidebar ======= -->
    <?php include '../sidebar/sidebar_m.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle py-2">
            <h1>ລົງ​ຄະ​ແນນ</h1>

        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-md-6">

                    <div class="card">
                        <div class="card-body">

                            <h4 class="my-4"><i class="bi bi-asterisk"></i> ​ສະ​ແກນເລກ​ທີ່​ໃບ​ລົງ​ຄະ​ແນນ ໃສ່​ຫ້ອງ​ທາງ​ລຸ່ມ</h4>

                            <form class="row g-3" action="s_action" method="post" id="scanForm">
                                <input type="hidden" name="m_id" value="<?= $_SESSION['m_id']; ?>">

                                <div class="col-12">
                                    <div class="col-12">
                                        <input type="text" name="s_no" id="s_no" class="form-control" maxlength="<?= $length ?>" placeholder="ເລກ​ທີ່​ໃບ​ລົງ​ຄະ​ແນນ" required>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="col-12">
                                        <h4><i class="bi bi-asterisk"></i> <?= $kill ?> ສ​ະ​ຫາຍທີ່​ທ່ານບໍ່​ເລືອກເອົາ</h4>
                                        <?php
                                        for ($i = 1; $i <= $kill; $i++) {
                                            echo '<input type="text" name="nc_id[]" id="nc_id_' . $i . '" class="form-control mb-3" maxlength="2" placeholder="ຜູ້​ທີ່ ' . $i . '" required>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="my-4"><i class="bi bi-person"></i> ຂໍ້​ມູນຜູ້​ສ​ະ​ໝັກ</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>ລ/ດ</th>
                                        <th>ຊື່ ແລະ ນາມ​ສະ​ກ​ຸນ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $row) { ?>
                                        <tr>
                                            <td class="text-center"><?= $row['nc_id']; ?></td>
                                            <td><?= $row['nc_name']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->



    <?php include '../style/script.php'; ?>

    <script>
        window.onload = function() {
            document.getElementById("s_no").focus();
        };

        // กำหนดจำนวนช่องจาก PHP
        const killCount = <?= $kill; ?>;

        // Focus control on Enter key press
        document.getElementById("scanForm").addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                let activeElement = document.activeElement;

                if (activeElement.id === "s_no") {
                    // focus ช่องแรก
                    if (killCount >= 1) document.getElementById("nc_id_1").focus();
                } else {
                    // check ว่าช่องที่ active อยู่เป็น nc_id_X
                    for (let i = 1; i <= killCount; i++) {
                        if (activeElement.id === "nc_id_" + i) {
                            if (i < killCount) {
                                // focus ช่องถัดไป
                                document.getElementById("nc_id_" + (i + 1)).focus();
                            } else {
                                // submit form หลังช่องสุดท้าย
                                document.getElementById("scanForm").submit();
                            }
                            break;
                        }
                    }
                }
            }
        });
    </script>


</body>

</html>