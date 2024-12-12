<?php
include 'm_action.php';
include '../apiurl.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ຜູ້​ແທນ</title>
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

    <div id="preloader"></div>
    <main id="main" class="main">

        <div class="pagetitle py-2">
            <h1>ຜູ້​ແທນ</h1>

        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between">
                                <form action="m_action" method="post" class="my-3">
                                    <button type="submit" name="add" class="btn btn-primary">ເພີ່ມ​ຜູ້​ແທນ</button>
                                </form>
                                <a href="excel" type="button" class="btn btn-success my-3" target="_blank">
                                    <i class="bi bi-filetype-xlsx"></i> EXCEL </a>
                                </a>
                            </div>

                            <!-- Default Table -->
                            <div class="scrollable-table">
                                <table class="table" id="example">
                                    <thead class="table-light text-center align-middle">
                                        <tr>
                                            <th rowspan="2">ລ/ດ</th>
                                            <th colspan="2">ສະ​ຖາ​ນະ</th>
                                            <th rowspan="2">ຊື່​ເຂົ້າ​ລະ​ບົບ</th>
                                            <th rowspan="2">​ລະ​ຫັດ​</th>
                                            <th rowspan="2">#</th>
                                        </tr>
                                        <tr>
                                            <th>ຜູ້​ສະ​ໝັກ​ຊຸດ​ເກົ່າ</th>
                                            <th>ຜູ້​ສະ​ໝັກ​ຊຸດ​ໃໝ່</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php

                                        $curl = curl_init();

                                        curl_setopt_array($curl, array(
                                            CURLOPT_URL => $apimember,
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
                                                <?php
                                                $sql = $conn->query("SELECT m_id FROM oscore WHERE m_id = '" . $obj[$i]->m_id . "'");
                                                $row_cnt = $sql->num_rows;

                                                if ($row_cnt > 0) {
                                                    echo "<td class='text-success'>ທ່ານ​ລົງ​ຄະ​ແນນ​ສຳ​ເລັ​ດ​ແລ້​ວ</td>";
                                                } else {
                                                    echo "<td class='text-danger'>ທ່ານ​ຍັງ​ບໍ່​ທັນ​ລົງ​ຄະ​ແນນ</td>";
                                                } ?>

                                                <?php
                                                $sql = $conn->query("SELECT m_id FROM nscore WHERE m_id = '" . $obj[$i]->m_id . "'");
                                                $row_cnt = $sql->num_rows;

                                                if ($row_cnt > 0) {
                                                    echo "<td class='text-success'>ທ່ານ​ລົງ​ຄະ​ແນນ​ສຳ​ເລັ​ດ​ແລ້​ວ</td>";
                                                } else {
                                                    echo "<td class='text-danger'>ທ່ານ​ຍັງ​ບໍ່​ທັນ​ລົງ​ຄະ​ແນນ</td>";
                                                } ?>
                                                <td><?= $obj[$i]->m_username; ?></td>
                                                <td><?= $obj[$i]->m_password; ?></td>
                                                <td>
                                                    <a href="editmember?edit=<?= $obj[$i]->m_id; ?>" type="button" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                                                    <a data-id="<?= $obj[$i]->m_id; ?>" href="m_action?delete=<?= $obj[$i]->m_id; ?>" type="button" class="btn btn-danger delete-btn"><i class="bi bi-trash"></i></a>
                                                </td>
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

        $(".delete-btn").click(function(e) {
            let userId = $(this).data('id');
            e.preventDefault();
            deleteConfirm(userId);
        })

        function deleteConfirm(userId) {
            Swal.fire({
                title: 'ຕ້ອງການຈະລົບຂໍ້ມູນອອກບໍ່?',

                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ຕົກລົງ',
                cancelButtonText: 'ຍົກເລີກ',
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'm_action',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'ລົບຂໍ້ມູນສຳເລັດແລ້ວ',

                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'member';
                                })
                            })
                            .fail(function() {
                                Swal.fire('Oops...', 'Something went wrong with ajax !', 'error')
                                window.location.reload();
                            });
                    });
                },
            });
        }


        var loader = document.getElementById('preloader');

        window.addEventListener('load', function() {
            loader.style.display = 'none';
        })
    </script>

</body>

</html>