<?php
include 'm_action.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ແກ້​ໄຂຜູ້​ແທນ</title>
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
        <div class="container">

            <div class="pagetitle py-2">
                <h1>ແກ້​ໄຂຜູ້​ແທນ</h1>

            </div><!-- End Page Title -->

            <section class="section">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">

                                <?php
                                $m_id = $_GET['edit'];
                                $sql = "SELECT * FROM member WHERE m_id = '$m_id'";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                ?>

                                <form class="row g-3 m-2" action="m_action" method="post">
                                    <input type="hidden" name="m_id" value="<?= $row['m_id']; ?>">
                                    <div class="col-md-12">
                                        <label for="m_password" class="form-label">​ລະ​ຫັດ​</label>
                                        <input type="text" name="m_password" value="<?= $row['m_password']; ?>" class="form-control" required>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" name="update" class="btn btn-success col-lg-6 col-10 mt-3">ອັບ​ເດດ​ຂໍ້​ມູນ</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </main><!-- End #main -->


    <?php include '../style/script.php'; ?>

</body>

</html>