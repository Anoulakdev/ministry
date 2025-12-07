<?php include 'a_action.php'; ?>

<?php

// $sql11 = "SELECT count(a_id) as ca_id FROM admin";

// $result11 = $conn->query($sql11);

// $row11 = $result11->fetch_assoc();



// $sql12 = "SELECT count(nc_id) as cnc_id FROM newcandidate";

// $result12 = $conn->query($sql12);

// $row12 = $result12->fetch_assoc();



// $sql13 = "SELECT count(m_id) as cco_id FROM member";

// $result13 = $conn->query($sql13);

// $row13 = $result13->fetch_assoc();


$sql16 = "SELECT * FROM sys WHERE s_id = 1";
$result16 = $conn->query($sql16);
$row16 = $result16->fetch_assoc();
$s_id = $row16['s_id'];
$s_kill1 = $row16['s_kill1'];
$s_kill2 = $row16['s_kill2'];

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ໜ້າ​ຫຼັກ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include '../style/stylesheet.php'; ?>

</head>

<body>

    <!-- ======= Header ======= -->
    <?php include '../navbar/navbar_a.php'; ?>

    <!-- ======= Sidebar ======= -->
    <?php include '../sidebar/sidebar_a.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle py-2">
            <h1>ໜ້າ​ຫຼັກ</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <div class="col-lg-12">
                    <div class="row">

                        <!-- Sales Card -->
                        <div class="col-12">
                            <div class="card info-card sales-card">

                                <div class="card-body">
                                    <h5 class="card-title">ອັບ​ເດດ​ຈຳ​ນວນ​ທີ່​ຖືກ​ຂີດ​ຂ້າ​ອອກ</h5>

                                    <form action="a_action" method="post" class="my-3">
                                        <input type="hidden" name="s_id" value="<?= $s_id; ?>">
                                        <div class="d-flex justify-content-start col-md-6 col-12">
                                            <div class="me-3">
                                                <label for="s_kill1" class="form-label me-3">ປະ​ທານ​ກວດກ​າ​ພັກ</label>
                                                <input type="text" name="s_kill1" id="s_kill1" class="form-control me-3" value="<?= $s_kill1; ?>" required>
                                            </div>
                                            <div class="me-3">
                                                <label for="s_kill2" class="form-label me-3">ຮອງປະ​ທານ​ກວດກ​າ​ພັກ​</label>
                                                <input type="text" name="s_kill2" id="s_kill2" class="form-control me-3" value="<?= $s_kill2; ?>" required>
                                            </div>

                                            <button class="btn btn-primary" type="submit" name="updatekill">ອັບ​ເດດ</button>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                    </div>
                </div>


            </div>
        </section>

    </main><!-- End #main -->



    <?php include '../style/script.php'; ?>

</body>

</html>