<?php include 'ns_action.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ລົງ​ຄະ​ແນນ</title>
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

        .custom-checkbox {
            border: 1px solid black;
        }
    </style>

</head>

<body class="toggle-sidebar">

    <!-- ======= Header ======= -->
    <?php include '../navbar/navbar_m.php'; ?>


    <main id="main" class="main">
        <div class="container-fluid">


            <div class="pagetitle py-2">
                <h1>ລົງ​ຄະ​ແນນ</h1>
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

                                        <h4 class="my-4"><i class="bi bi-asterisk"></i> ຕິກອອກ 05 ສະຫາຍ ທີ່ທ່ານບໍ່ເຫັນດີ.</h4>

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
                                            ?>

                                            <div class="scrollable-table">
                                                <table class="table" id="example">
                                                    <thead class="table-light text-center align-middle">
                                                        <tr>
                                                            <th>ລ/ດ</th>
                                                            <th>ຮູບ​ພາບ</th>
                                                            <th>​ຊື່ ແລະ ນາມ​ສະ​ກຸນ</th>
                                                            <th>​ອາ​ຍຸ</th>
                                                            <th>ຕຳ​ແໜ່ງກຳ​ມະ​ບານ</th>
                                                            <th>ຕຳ​ແໜ່ງລັດ</th>
                                                            <th>ຕຳ​ແໜ່ງພັກ</th>
                                                            <th>ກົມ​ກອງ​​ປະ​ຈຳ​ການ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center align-middle">
                                                        <?php $i = 1; ?>
                                                        <?php foreach ($data as $row) { ?>
                                                            <tr>
                                                                <td><?= $i++; ?>. <input class="form-check-input custom-checkbox" type="checkbox" name="nc_id[]" value="<?= $row['nc_id']; ?>"></td>
                                                                <td>
                                                                    <?php if ($row['nc_pic'] != "") { ?>
                                                                        <img src="../uploads/candidate/<?= $row['nc_pic']; ?>" width="60" height="65" class="rounded-circle">
                                                                    <?php } else { ?>
                                                                        <img src="../assets/img/profile-picture.jpg" alt="Profile" width="60" height="65" class="rounded-circle">
                                                                    <?php } ?>
                                                                </td>
                                                                <td class="text-start"><?= $row['nc_name']; ?></td>
                                                                <td><?= $row['nc_age']; ?></td>
                                                                <td><?= $row['nc_kammaban']; ?></td>
                                                                <td><?= $row['nc_lat']; ?></td>
                                                                <td><?= $row['nc_phak']; ?></td>
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

        // Checkbox logic to enable/disable the submit button based on selection
        for (var i = 0; i < checkboxs.length; i++) {
            checkboxs[i].onclick = function() {
                var checkedCount = document.querySelectorAll('input[name="nc_id[]"]:checked').length;
                if (checkedCount >= limit) {
                    for (var j = 0; j < checkboxs.length; j++) {
                        if (!checkboxs[j].checked) {
                            checkboxs[j].disabled = true;
                        }
                    }
                    submitButton.disabled = false;
                } else {
                    for (var j = 0; j < checkboxs.length; j++) {
                        checkboxs[j].disabled = false;
                    }
                    submitButton.disabled = true;
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