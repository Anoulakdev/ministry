<?php include 'os_action.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ລົງ​ຄະ​ແນນຊຸດ​ເກົ່າ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include '../style/stylesheet.php'; ?>

    <style>
        .scrollable-table {
            width: 100%;
            overflow-x: auto;
        }

        .scrollable-table table {
            width: 100%;
            white-space: nowrap;
        }
    </style>

</head>

<body class="toggle-sidebar">

    <!-- ======= Header ======= -->
    <?php include '../navbar/navbar_m.php'; ?>

    <main id="main" class="main">
        <div class="container-fluid">


            <div class="pagetitle py-2">
                <h1>ລົງ​ຄະ​ແນນຊຸດ​ເກົ່າ</h1>
            </div><!-- End Page Title -->

            <section class="section dashboard">
                <div class="row">

                    <!-- Left side columns -->
                    <div class="col-lg-12">
                        <div class="row">

                            <!-- Sales Card -->

                            <div class="card">

                                <div class="card-body">

                                    <?php
                                    $result = $conn->query("SELECT * FROM oscore WHERE m_id = '" . $_SESSION["m_id"] . "'");
                                    $row_cnt = $result->num_rows;

                                    if ($row_cnt > 0) { ?>

                                        <h1 class="my-5 text-success">ທ່ານ​ໄດ້​ລົງ​ຄະ​ແນນ​ສ​ຳ​ເລັ​ດ​ແລ້ວ</h1>

                                        <a href="naddscore" type="button" class="btn btn-primary">ຕໍ່​ໄປ</a>

                                        <?php } else { ?>

                                            <h4 class="my-4"><i class="bi bi-asterisk"></i> ຈົ່ງເລືອກ​ເອົາຫ້ອງ​ສຶບ​ຕໍ່ ແລະ ບໍ່​ສືບ​ຕໍ່</h4>

                                            <form class="row g-3" action="os_action" method="post">
                                                <input type="hidden" name="m_id" value="<?= $_SESSION['m_id']; ?>">

                                                <?php
                                                $query = "SELECT * FROM oldcandidate";
                                                $stmt = $conn->prepare($query);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $data = array();
                                                while ($row = $result->fetch_assoc()) {
                                                    $data[] = $row;
                                                }
                                                ?>

                                                <div class="scrollable-table">
                                                    <table class="table" id="example">
                                                        <thead class="table-light text-center align-middle">
                                                            <tr>
                                                                <th rowspan="2">ຄະ​ແນນ</th>
                                                                <th rowspan="2">ໝາຍ​ເຫດ</th>
                                                                <th rowspan="2">ຮູບ​ພາບ</th>
                                                                <th rowspan="2">​ຊື່ ແລະ ນາມ​ສະ​ກຸນ</th>
                                                                <th rowspan="2">​ອາ​ຍຸ</th>
                                                                <th colspan="3" class="text-center">ຕຳ​ແໜ່ງ</th>
                                                                <th rowspan="2">ກົມ​ກອງ​ບ່ອນ​ປະ​ຈຳ​ການ</th>
                                                            </tr>
                                                            <tr>
                                                                <th>ພັກ</th>
                                                                <th>​ລັດ</th>
                                                                <th>​ຊາ​ວ​ໜຸ່ມ</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center align-middle">
                                                            <?php $i = 1; ?>
                                                            <?php foreach ($data as $row) { ?>
                                                                <tr>
                                                                    <td><input class="form-check-input" type="radio" name="osc_result_<?= $row['oc_id']; ?>" value="1" checked onclick="toggleTextarea(<?= $row['oc_id']; ?>, true)">
                                                                        <label class="form-check-label">
                                                                            ສືບ​ຕໍ່
                                                                        </label>

                                                                        <input class="form-check-input" type="radio" name="osc_result_<?= $row['oc_id']; ?>" value="0" onclick="toggleTextarea(<?= $row['oc_id']; ?>, false)">
                                                                        <label class="form-check-label">
                                                                            ບໍ່ສືບ​ຕໍ່
                                                                        </label>
                                                                    </td>
                                                                    <td>
                                                                        <textarea name="osc_reason_<?= $row['oc_id']; ?>" rows="3" class="form-control" style="width: 200px;" id="osc_reason_<?= $row['oc_id']; ?>" disabled></textarea>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($row['oc_pic'] != "") { ?>
                                                                            <img src="../uploads/candidate/<?= $row['oc_pic']; ?>" width="60" height="65" class="rounded-circle">
                                                                        <?php } else { ?>
                                                                            <img src="../assets/img/profile-picture.jpg" alt="Profile" width="60" height="65" class="rounded-circle">
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td class="text-start"><?= $row['oc_name']; ?></td>
                                                                    <td><?= $row['oc_age']; ?></td>
                                                                    <td><?= $row['oc_phak']; ?></td>
                                                                    <td><?= $row['oc_lat']; ?></td>
                                                                    <td><?= $row['oc_saonoum']; ?></td>
                                                                    <td><?= $row['oc_part']; ?></td>
                                                                </tr>

                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-md-10">
                                                    <button type="submit" name="add" id="add" class="btn btn-primary">ລົງ​ຄະ​ແນນ</button>
                                                    <button class="btn btn-primary" type="button" disabled id="load">
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                        ກຳ​ລັງ​ລົງ​ຄະ​ແນນ...
                                                    </button>
                                                </div>
                                            </form>
                                        <?php } ?>

                                </div>

                            </div>

                        </div>

                    </div>
                </div><!-- End Left side columns -->


            </section>

        </div>

    </main><!-- End #main -->



    <?php include '../style/script.php'; ?>

    <script>
        function toggleTextarea(id, disable) {
            const textarea = document.getElementById('osc_reason_' + id);
            textarea.disabled = disable;
        }

        document.getElementById("load").style.display = "none"

        function loads() {
            document.getElementById("add").style.display = "none"
            document.getElementById("load").style.display = "inline"
        }
    </script>

</body>

</html>