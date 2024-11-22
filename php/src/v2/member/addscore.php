<?php
include 's_action.php';
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


    <main id="main" class="main">
        <div class="container-fluid">
            <div class="pagetitle ">
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

                                    <h4 class="my-4"><i class="bi bi-asterisk"></i> ​ສະ​ແກນເລກ​ທີ່​ໃບ​ລົງ​ຄະ​ແນນ ໃສ່​ຫ້ອງ​ທາງ​ລຸ່ມ</h4>

                                    <form class="row g-3" action="s_action" method="post" id="scanForm">
                                        <input type="hidden" name="m_id" value="<?= $_SESSION['m_id']; ?>">

                                        <div class="col-md-6 col-12">
                                            <div class="col-12">
                                                <input type="text" name="s_no" id="s_no" class="form-control" maxlength="3" placeholder="ເລກ​ທີ່​ໃບ​ລົງ​ຄະ​ແນນ" required>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="col-12">
                                                <h4><i class="bi bi-asterisk"></i> 3 ສ​ະ​ຫາຍທີ່​ທ່ານບໍ່​ເລືອກເອົາ</h4>
                                                <input type="text" name="nc_id[]" id="nc_id_1" class="form-control mb-3" maxlength="2" placeholder="ຜູ້​ທີ່ 1" required>
                                                <input type="text" name="nc_id[]" id="nc_id_2" class="form-control mb-3" maxlength="2" placeholder="ຜູ້​ທີ່ 2" required>
                                                <input type="text" name="nc_id[]" id="nc_id_3" class="form-control" maxlength="2" placeholder="ຜູ້​ທີ່ 3" required>
                                            </div>
                                        </div>
                                    </form>

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
        window.onload = function() {
            document.getElementById("s_no").focus();
        };

        // Focus control on Enter key press
        document.getElementById("scanForm").addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                // Prevent form submission
                event.preventDefault();
                let activeElement = document.activeElement;
                
                if (activeElement.id === "s_no") {
                    document.getElementById("nc_id_1").focus();
                } else if (activeElement.id === "nc_id_1") {
                    document.getElementById("nc_id_2").focus();
                } else if (activeElement.id === "nc_id_2") {
                    document.getElementById("nc_id_3").focus();
                } else if (activeElement.id === "nc_id_3") {
                    document.getElementById("scanForm").submit(); // Submit the form after the last field
                }
            }
        });
    </script>

</body>

</html>