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

    <title>ລາຍ​ລະ​ອຽດ​ການ​ລົງ​ຄະ​​ແນນ</title>
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

<body class="toggle-sidebar">

    <!-- ======= Header ======= -->
    <?php include '../navbar/navbar_m.php'; ?>

    <!-- ======= Sidebar ======= -->
    <?php include '../sidebar/sidebar_m.php'; ?>

    <div id="preloader"></div>
    <main id="main" class="main">

        <div class="pagetitle py-2">
            <h1>ລາຍ​ລະ​ອຽດ​ການ​ລົງ​ຄະ​​ແນນ</h1>

        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">

                            <!-- Default Table -->
                            <div class="scrollable-table mt-3">
                                <table class="table" id="example">
                                    <thead class="table-light text-center align-middle">
                                        <tr>
                                            <th>ໃບ​ລົງ​ຄະ​ແນນ</th>
                                            <th>ຮູບ​ພາບ</th>
                                            <th>​ຊື່ ແລະ ນາມ​ສະ​ກຸນ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $curl = curl_init();

                                        curl_setopt_array($curl, array(
                                            CURLOPT_URL => $apimembersearch . '?m_id=' . urlencode($_SESSION['m_id']),
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
                                                <td class="text-center"><?= $obj[$i]->s_no; ?></td>
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

                            <!-- End Default Table Example -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->



    <?php include '../style/script.php'; ?>

    <script>
        $(function() {
            $("#example").DataTable({
                "oLanguage": {
                    "sProcessing": "ກຳລັງດຳເນີນການ...",
                    "sLengthMenu": "ສະແດງ _MENU_ ແຖວ",
                    "sZeroRecords": "ບໍ່ມີຂໍ້ມູນຄົ້ນຫາ",
                    "sInfo": "ສະແດງ _START_ ຖີງ _END_ ຈາກ _TOTAL_ ແຖວ",
                    "sInfoEmpty": "ສະແດງ 0 ຖີງ 0 ຈາກ 0 ແຖວ",
                    "sInfoFiltered": "(ຈາກຂໍ້ມູນທັງໝົດ _MAX_ ແຖວ)",
                    "sSearch": "ຄົ້ນຫາ :",
                    "oPaginate": {
                        "sFirst": "ເລີ່ມຕົ້ນ",
                        "sPrevious": "ກັບຄືນ",
                        "sNext": "ຕໍ່ໄປ",
                        "sLast": "ສຸດທ້າຍ"
                    }
                },
                "responsive": false,
                "lengthChange": true,
                "autoWidth": false,

            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });

        var loader = document.getElementById('preloader');

        window.addEventListener('load', function() {
            loader.style.display = 'none';
        })
    </script>

</body>

</html>