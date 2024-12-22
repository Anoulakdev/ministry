<?php include 'ns_action.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ລົງ​ຄະ​ແນນຊຸດ​ໃໝ່</title>
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
                <h1>ລົງ​ຄະ​ແນນຊຸດ​ໃໝ່</h1>
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
                                    $result = $conn->query("SELECT * FROM nscore WHERE m_id = '" . $_SESSION["m_id"] . "'");
                                    $row_cnt = $result->num_rows;

                                    if ($row_cnt > 0) { ?>

                                        <h1 class="my-5 text-success">ທ່ານ​ໄດ້​ລົງ​ຄະ​ແນນ​ສ​ຳ​ເລັ​ດ​ແລ້ວ</h1>

                                    <?php } else { ?>

                                        <h4 class="my-4 lh-base"><i class="bi bi-asterisk"></i> ບັນດາຄະນະໜ່ວຍກໍາມະບານຮາກຖານ ລົງສະໝັກຊຸດໃໝ່ ( ໃຫ້ຕິກເອົາ 5 ສະຫາຍ ທີ່ທ່ານເລືອກເອົາ).</h4>

                                        <form class="row g-3" action="ns_action" method="post">
                                            <input type="hidden" name="m_id" value="<?= $_SESSION['m_id']; ?>">

                                            <?php
                                            $query = "SELECT * FROM newcandidate";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $data = array();
                                            while ($row = $result->fetch_assoc()) {
                                                $data[] = $row;
                                            }
                                            $stmt->close(); // ปิด statement
                                            $result->close(); // ปิด result set
                                            $conn->close(); // ปิดการเชื่อมต่อ
                                            ?>

                                            <div class="scrollable-table">
                                                <table class="table" id="example">
                                                    <thead class="table-light text-center align-middle">
                                                        <tr>
                                                            <th>ລ/ດ</th>
                                                            <th>ຊື່ ແລະ ນາມ​ສະ​ກຸນ</th>
                                                            <th>​ອາຍ​ຸ</th>
                                                            <th>​ຕຳ​ແໜ່ງ​ກຳ​ມະ​ບານ</th>
                                                            <th>​ຕຳ​ແໜ່ງ​ພັກ</th>
                                                            <th>​ຕຳ​ແໜ່ງ​ລັດ</th>
                                                            <th>​ກົມ​ກອງ​ປະ​ຈຳ​ການ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center align-middle">
                                                        <?php $i = 1; ?>
                                                        <?php foreach ($data as $row) { ?>
                                                            <tr>
                                                                <td><?= $i++; ?>. <input class="form-check-input" type="checkbox" name="nc_id[]" value="<?= $row['nc_id']; ?>"></td>
                                                                <td class="text-start"><?= $row['nc_name']; ?></td>
                                                                <td><?= $row['nc_age']; ?></td>
                                                                <td><?= $row['nc_kammaban']; ?></td>
                                                                <td><?= $row['nc_phak']; ?></td>
                                                                <td><?= $row['nc_lat']; ?></td>
                                                                <td><?= $row['nc_part']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-md-10">
                                                <button disabled type="submit" name="add" id="add" class="btn btn-primary">ລົງ​ຄະ​ແນນ</button>
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

        </div>
        </section>

        </div>

    </main><!-- End #main -->



    <?php include '../style/script.php'; ?>

    <script>
        var checkboxs = document.getElementsByName('nc_id[]');
        var submitButton = document.getElementById('add');
        var loadingButton = document.getElementById('load');
        var limit = 5;
        for (var i = 0; i < checkboxs.length; i++) {
            checkboxs[i].onclick = function() {
                var checkedCount = document.querySelectorAll('input[name="nc_id[]"]:checked').length;
                if (checkedCount >= limit) {
                    for (var j = 0; j < checkboxs.length; j++) {
                        if (!checkboxs[j].checked) {
                            checkboxs[j].disabled = true;
                            submitButton.disabled = false;
                        }
                    }
                } else {
                    for (var j = 0; j < checkboxs.length; j++) {
                        checkboxs[j].disabled = false;
                        submitButton.disabled = true;
                    }
                }
            }
        }

        // Hide the loading button initially
        loadingButton.style.display = "none";

        // Add onsubmit handler to the form
        document.querySelector("form").onsubmit = function() {
            // Hide submit button and show loading spinner
            submitButton.style.display = "none";
            loadingButton.style.display = "inline";

            // Let the form be submitted as usual
            return true;
        };
    </script>

</body>

</html>