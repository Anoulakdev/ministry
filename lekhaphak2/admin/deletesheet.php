<?php include 's_action.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ລົ​ບ​ໃບ​ລົງ​ຄະ​​ແນນ​ຜິດ</title>
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

<body>

    <!-- ======= Header ======= -->
    <?php include '../navbar/navbar_a.php'; ?>

    <!-- ======= Sidebar ======= -->
    <?php include '../sidebar/sidebar_a.php'; ?>

    <main id="main" class="main">
        <div class="container">



            <div class="pagetitle py-2">
                <h1>ລົ​ບ​ໃບ​ລົງ​ຄະ​​ແນນ​ຜິດ</h1>

            </div><!-- End Page Title -->

            <section class="section">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="my-3">

                                </div>


                                <?php
                                $query = "SELECT DISTINCT m.m_username, nsc.s_no FROM nscore as nsc inner join member as m on nsc.m_id = m.m_id";
                                $stmt = $conn->prepare($query);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $data = array();
                                while ($row = $result->fetch_assoc()) {
                                    $data[] = $row;
                                }
                                ?>
                                <!-- Default Table -->
                                <div class="scrollable-table">
                                    <table class="table" id="example">
                                        <thead>
                                            <tr>
                                                <th>ລ/ດ</th>
                                                <th>ກຳ​ມະ​ການ</th>
                                                <th>ເລກ​ທີໃບ​ລົງ​ຄະ​ແນນ</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($data as $row) { ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $row['m_username']; ?></td>
                                                    <td><?= $row['s_no']; ?></td>

                                                    <td>
                                                        <a data-id="<?= $row['s_no']; ?>" href="s_action?deleteall=<?= $row['s_no']; ?>" type="button" class="btn btn-danger delete-btn"><i class="bi bi-trash"></i></a>
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
        </div>

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
                title: 'ຕ້ອງການຈະລົບໃບ​ລົງ​ຄະ​ແນນອອກບໍ່?',

                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ຕົກລົງ',
                cancelButtonText: 'ຍົກເລີກ',
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 's_action',
                                type: 'GET',
                                data: 'deleteall=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'ລົບຂໍ້ມູນສຳເລັດແລ້ວ',

                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'deletesheet';
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
    </script>

</body>

</html>