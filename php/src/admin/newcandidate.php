<?php include 'nc_action.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ຜູ້​ສະ​ໝັກຊຸດ​ໃໝ່</title>
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
        <div class="container-fluid">



            <div class="pagetitle py-2">
                <h1>ຜູ້​ສະ​ໝັກຊຸດ​ໃໝ່</h1>

            </div><!-- End Page Title -->

            <section class="section">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="modal fade" id="addModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">ເພີ່ມຜູ້ສະ​ໝັກ</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="row g-3" action="nc_action" method="post">

                                                    <div class="col-md-12">
                                                        <label for="nc_name" class="form-label">ຊື່ ແລະ ນາມ​ສະ​ກຸນ</label>
                                                        <input type="text" name="nc_name" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="nc_age" class="form-label">​ອາຍ​ຸ</label>
                                                        <input type="number" name="nc_age" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="nc_kammaban" class="form-label">​ຕຳ​ແໜ່ງ​ກຳ​ມະ​ບານ</label>
                                                        <input type="text" name="nc_kammaban" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="nc_phak" class="form-label">​ຕຳ​ແໜ່ງ​ພັກ</label>
                                                        <input type="text" name="nc_phak" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="nc_lat" class="form-label">​ຕຳ​ແໜ່ງ​ລັດ</label>
                                                        <input type="text" name="nc_lat" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="nc_part" class="form-label">​ກົມ​ກອງ​ປະ​ຈຳ​ການ</label>
                                                        <input type="text" name="nc_part" class="form-control" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">​ປິດ</button>
                                                        <button type="submit" name="add" class="btn btn-primary">ເພີ່ມ​ຂໍ້​ມູນ</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addModal">
                                    ເພີ່ມຜູ້ສະ​ໝັກ
                                </button>

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
                                <!-- Default Table -->
                                <div class="scrollable-table">
                                    <table class="table" id="example">
                                        <thead class="table-light text-center align-middle">
                                            <tr>
                                                <th>ລ/ດ</th>
                                                <th>​ຊື່ ແລະ ນາມ​ສະ​ກຸນ</th>
                                                <th>​ອາ​ຍຸ</th>
                                                <th>ຕຳ​ແໜ່ງກຳ​ມະ​ບານ</th>
                                                <th>ຕຳ​ແໜ່ງພັກ</th>
                                                <th>​ຕຳ​ແໜ່ງ​ລັດ</th>
                                                <th>ກົມ​ກອງ​​ປະ​ຈຳ​ການ</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center align-middle">
                                            <?php $i = 1; ?>
                                            <?php foreach ($data as $row) { ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td class="text-start"><?= $row['nc_name']; ?></td>
                                                    <td><?= $row['nc_age']; ?></td>
                                                    <td><?= $row['nc_kammaban']; ?></td>
                                                    <td><?= $row['nc_phak']; ?></td>
                                                    <td><?= $row['nc_lat']; ?></td>
                                                    <td><?= $row['nc_part']; ?></td>
                                                    <td>
                                                        <a href="#edit_<?= $row['nc_id']; ?>" type="button" class="btn btn-primary" data-bs-toggle="modal"><i class="bi bi-pencil-square"></i></a>
                                                        <a data-id="<?= $row['nc_id']; ?>" href="nc_action?delete=<?= $row['nc_id']; ?>" type="button" class="btn btn-danger delete-btn"><i class="bi bi-trash"></i></a>
                                                    </td>
                                                </tr>

                                                <div class="modal fade" id="edit_<?= $row['nc_id']; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">ແກ້​ໄຂຜູ້ສະ​ໝັກ</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="row g-3" action="nc_action" method="post">
                                                                    <input type="hidden" name="nc_id" value="<?= $row['nc_id']; ?>">

                                                                    <div class="col-md-12">
                                                                        <label for="nc_name" class="form-label">ຊື່ ແລະ ນາມ​ສະ​ກຸນ</label>
                                                                        <input type="text" name="nc_name" value="<?= $row['nc_name']; ?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-md-12 mt-2">
                                                                        <label for="nc_age" class="form-label">​ອາ​ຍຸ</label>
                                                                        <input type="text" name="nc_age" value="<?= $row['nc_age']; ?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-md-12 mt-2">
                                                                        <label for="nc_kammaban" class="form-label">​ຕຳ​ແໜ່ງ​ກຳ​ມະ​ບານ</label>
                                                                        <input type="text" name="nc_kammaban" value="<?= $row['nc_kammaban']; ?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-md-12 mt-2">
                                                                        <label for="nc_phak" class="form-label">​ຕຳ​ແໜ່ງ​ພັກ</label>
                                                                        <input type="text" name="nc_phak" value="<?= $row['nc_phak']; ?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-md-12 mt-2">
                                                                        <label for="nc_lat" class="form-label">​ຕຳ​ແໜ່ງ​ລັດ</label>
                                                                        <input type="text" name="nc_lat" value="<?= $row['nc_lat']; ?>" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-md-12 mt-2">
                                                                        <label for="nc_part" class="form-label">​ກົມ​ກອງ​​ປະ​ຈຳ​ການ</label>
                                                                        <input type="text" name="nc_part" value="<?= $row['nc_part']; ?>" class="form-control" required>
                                                                    </div>


                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">​ປິດ</button>
                                                                        <button type="submit" name="update" class="btn btn-success">ອັບ​ເດດ​ຂໍ້​ມູນ</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

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
                                url: 'nc_action',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'ລົບຂໍ້ມູນສຳເລັດແລ້ວ',

                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'newcandidate';
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