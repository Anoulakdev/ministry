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

    <title>ລາຍ​ລະ​ອຽດ​ລົງ​ຄະ​ແນນ​ຊຸດ​ໃໝ່</title>
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
    if (isset($_GET['nc_id'])) {
        $nc_id = $_GET['nc_id'];
    } else {
        $nc_id = "";
    }
    ?>

    <div id="preloader"></div>
    <main id="main" class="main">

        <div class="pagetitle py-2">
            <h1>ລາຍ​ລະ​ອຽດ​ລົງ​ຄະ​ແນນ​ຊຸດ​ໃໝ່</h1>

        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-start">
                                <form action="" method="GET" class="my-3 d-flex align-items-center">
                                    <select name="nc_id" class="form-select me-3">
                                        <option value="">---ເລືອກຜູ້​ສະ​ໝັກ​ຊຸດ​ໃໝ່---</option>
                                        <?php
                                        $query3 = 'SELECT * FROM newcandidate ORDER BY nc_id ASC';
                                        $stmt3 = $conn->prepare($query3);
                                        $stmt3->execute();
                                        $result3 = $stmt3->get_result();

                                        while ($row3 = $result3->fetch_assoc()) {
                                            $selected = ($nc_id == $row3['nc_id']) ? "selected" : "";
                                            echo "<option value='" . htmlspecialchars($row3['nc_id']) . "' $selected>" . htmlspecialchars($row3['nc_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <button class="btn btn-primary" type="submit" name="filter">ຄົ້ນຫາ</button>
                                </form>
                            </div>


                            <hr />

                            <?php if (isset($_GET['filter'])) { ?>

                                <!-- <div class="d-flex justify-content-end">
                                    <a href="ocexcel?nc_id=<?= htmlspecialchars($_GET['nc_id']); ?>" class="btn btn-success my-3" target="_blank">
                                        <i class="bi bi-filetype-xlsx"></i> EXCEL
                                    </a>
                                </div> -->
                                <!-- Default Table -->
                                <div class="scrollable-table">
                                    <table class="table" id="example">
                                        <thead class="table-light text-center align-middle">
                                            <tr>
                                                <th style="width: 15%;">ລ/ດ</th>
                                                <th>ຜູ້​ແທນ</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php

                                            $curl = curl_init();

                                            curl_setopt_array($curl, array(
                                                CURLOPT_URL => $apincheckscore . '?nc_id=' . $nc_id,
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
                                                    <td class="text-center"><?= $ni++; ?></td>
                                                    <td class="text-center"><?= $obj[$i]->m_username; ?></td>

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