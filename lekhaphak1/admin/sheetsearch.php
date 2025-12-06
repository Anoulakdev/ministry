<?php
session_start();
ob_start();
include '../config.php';
include 'status.php';
include '../apiurl.php';
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ລາຍ​ລະ​ອຽດ​ໃບ​ລົງ​ຄະ​ແນນ</title>
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

        #preloader {
            background: #ffffff url(../assets/img/Rolling.gif) no-repeat center center;
            background-size: 5%;
            height: 100vh;
            width: 100%;
            position: fixed;
            z-index: 100;
        }
    </style>


</head>

<body>

    <!-- ======= Header ======= -->
    <?php include '../navbar/navbar_a.php'; ?>

    <!-- ======= Sidebar ======= -->
    <?php include '../sidebar/sidebar_a.php'; ?>

    <?php
    if (isset($_GET['s_no'])) {
        $s_no = $_GET['s_no'];
    } else {
        $s_no = "";
    }
    ?>

    <div id="preloader"></div>
    <main id="main" class="main">

        <div class="pagetitle py-2">
            <h1>ລາຍ​ລະ​ອຽດ​ໃບ​ລົງ​ຄະ​ແນນ</h1>

        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-start">
                                <form action="" method="GET" class="my-3 d-flex align-items-center">

                                    <input type="text" name="s_no" id="s_no" class="form-control me-3" value="<?= $s_no; ?>" placeholder="ປ້ອນ​ເລກ​ໃບ​​ບິນ" required>

                                    <button class="btn btn-primary" type="submit" name="filter">ຄົ້ນຫາ</button>
                                </form>
                            </div>


                            <hr />

                            <?php if (isset($_GET['filter'])) { ?>
                                <!-- Default Table -->
                                <div class="scrollable-table">
                                    <table class="table" id="example">
                                        <thead class="table-light text-center align-middle">
                                            <tr>
                                                <th rowspan="2">ລ/ດ</th>
                                                <th rowspan="2">ຮູບ​ພາບ</th>
                                                <th rowspan="2">​ຊື່ ແລະ ນາມ​ສະ​ກຸນ</th>
                                            </tr>


                                        </thead>
                                        <tbody>
                                            <?php

                                            $curl = curl_init();

                                            curl_setopt_array($curl, array(
                                                CURLOPT_URL => $apisheetsearch . '?s_no=' . $s_no,
                                                CURLOPT_RETURNTRANSFER => true,
                                                CURLOPT_ENCODING => '',
                                                CURLOPT_MAXREDIRS => 10,
                                                CURLOPT_TIMEOUT => 0,
                                                CURLOPT_FOLLOWLOCATION => true,
                                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                CURLOPT_CUSTOMREQUEST => 'GET',
                                            ));

                                            $response = curl_exec($curl);
                                            $obj = json_decode($response);
                                            // echo $obj[0]->name;
                                            ?>

                                            <?php $ni = 1; ?>
                                            <?php for ($i = 0; $i < count($obj); $i++) { ?>
                                                <tr>
                                                    <td><?= $ni++; ?></td>
                                                    <td class="text-center">
                                                        <?php if ($obj[$i]->nc_pic != "") { ?>
                                                            <img src="../uploads/candidate/<?= $obj[$i]->nc_pic; ?>" width="60" height="65" class="rounded-circle">
                                                        <?php } else { ?>
                                                            <img src="../assets/img/profile-picture.jpg" alt="Profile" width="60" height="65" class="rounded-circle">
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center"><?= $obj[$i]->nc_name; ?></td>

                                                </tr>

                                            <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                            <?php } ?>
                            <!-- End Default Table Example -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->



    <?php include '../style/script.php'; ?>

    <script>
        var loader = document.getElementById('preloader');

        window.addEventListener('load', function() {
            loader.style.display = 'none';
        })
    </script>

</body>

</html>