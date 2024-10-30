<?php
include 's_action.php';
include '../apiurl.php';
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

                                    <h4 class="my-4"><i class="bi bi-asterisk"></i> ຈົ່ງຄິກ​ສະ​ແກນ barcode ໃສ່​ຫ້ອງ​ທາງ​ລຸ່ມ</h4>

                                    <form class="row g-3" action="s_action" method="post">
                                        <input type="hidden" name="m_id" value="<?= $_SESSION['m_id']; ?>">

                                        <div class="col-md-3 col-12">
                                            <input type="text" name="barcode" id="barcode" class="form-control" maxlength="5" placeholder="barcode" required>
                                        </div>

                                    </form>

                                    <div class="scrollable-table">
                                        <table class="table" id="example2">
                                            <thead class="table-light text-center align-middle">
                                                <tr>
                                                    <th rowspan="2">ຮູບ​ພາບ</th>
                                                    <th rowspan="2">​ຊື່ ແລະ ນາມ​ສະ​ກຸນ</th>
                                                    <th rowspan="2">​ອາ​ຍຸ</th>
                                                    <th colspan="3" class="text-center">ຕຳ​ແໜ່ງ</th>
                                                    <th rowspan="2">ກົມ​ກອງ​ບ່ອນ​ປະ​ຈຳ​ການ</th>
                                                </tr>
                                                <tr>
                                                    <th>​ຊາ​ວ​ໜຸ່ມ</th>
                                                    <th>​ລັດ</th>
                                                    <th>ພັກ</th>
                                                </tr>

                                            </thead>
                                            <tbody class="text-center align-middle">
                                                <?php

                                                $curl = curl_init();

                                                curl_setopt_array($curl, array(
                                                    CURLOPT_URL => $apibarcode . '?m_id=' . $_SESSION['m_id'],
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
                                                        <td>
                                                            <?php if ($obj[$i]->nc_pic != "") { ?>
                                                                <img src="../uploads/candidate/<?= $obj[$i]->nc_pic; ?>" width="60" height="65" class="rounded-circle">
                                                            <?php } else { ?>
                                                                <img src="../assets/img/profile-picture.jpg" alt="Profile" width="60" height="65" class="rounded-circle">
                                                            <?php } ?>
                                                        </td>
                                                        <td class="text-start"><?= $obj[$i]->nc_name; ?></td>
                                                        <td><?= $obj[$i]->nc_age; ?></td>
                                                        <td><?= $obj[$i]->nc_saonoum; ?></td>
                                                        <td><?= $obj[$i]->nc_lat; ?></td>
                                                        <td><?= $obj[$i]->nc_phak; ?></td>
                                                        <td><?= $obj[$i]->nc_part; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
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
        window.addEventListener('DOMContentLoaded', (event) => {
            <?php if (isset($_SESSION['message'])): ?>
                var messageType = '<?= $_SESSION['message_type']; ?>'; // Get the message type
                var message = '<?= $_SESSION['message']; ?>'; // Get the message

                // Show Toastr notification based on message type
                if (messageType === 'success') {
                    toastr.success(message, 'Success!', {
                        timeOut: 2000
                    });
                } else if (messageType === 'error') {
                    toastr.error(message, 'Error!', {
                        timeOut: 2000
                    });
                }

                // Unset session variables to avoid repeated alerts
                <?php
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            <?php endif; ?>
        });

        window.onload = function() {
            document.getElementById("barcode").focus();
        };

        var loader = document.getElementById('preloader');

        window.addEventListener('load', function() {
            loader.style.display = 'none';
        })

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

        var submitButton = document.getElementById('add');
        var loadingButton = document.getElementById('load');

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