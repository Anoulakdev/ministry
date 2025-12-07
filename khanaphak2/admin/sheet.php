<?php
include 's_action.php';
include '../candidatecounts.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ໃບ​ລົງ​ຄະ​ແນນ</title>
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
                <h1>ໃບ​ລົງ​ຄະ​ແນນ</h1>

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
                                                <h5 class="modal-title">ເພີ່ມໃບ​ລົງ​ຄະ​ແນນ</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="row g-3" action="s_action" method="post">

                                                    <div class="col-md-12">
                                                        <label for="start" class="form-label">ເລກ​ທີ່ເລີ່ມ​ຕົ້ນ</label>
                                                        <input type="text" name="start" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="end" class="form-label">ເລກ​ທີ່​ສຸດ​ທ້າຍ</label>
                                                        <input type="text" name="end" class="form-control" required>
                                                    </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">​ປິດ</button>
                                                <button type="submit" name="add" class="btn btn-primary">ເພີ່ມ​ຂໍ້​ມູນ</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between my-3">
                                    <div>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                            ເພີ່ມໃບ​ລົງ​ຄະ​ແນນ
                                        </button>
                                    </div>
                                    <!-- <form method="POST" action="printall" target="_blank">
                                        <div class="d-flex justify-content-end">
                                            <input type="number" name="page1" class="form-control me-2" required min="1" placeholder="ໜ້າ​ທຳ​ອິດ">
                                            <input type="number" name="page2" class="form-control me-2" required min="1" placeholder="​ໜ້າ​ສຸດ​ທ້າຍ">

                                            <button class="btn btn-secondary btn-sm">
                                                <i class="bi bi-printer"></i> ພີມ​
                                            </button>
                                        </div>
                                    </form> -->
                                </div>


                                <?php
                                $query = "SELECT * FROM sheet";
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
                                                <th>ສະ​ຖາ​ນະ</th>
                                                <th>ເລກ​ທີໃບ​ລົງ​ຄະ​ແນນ</th>
                                                <!-- <th>#</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($data as $row) { ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <?php
                                                    $sql1 = $conn->query("SELECT COUNT(s_no) AS sno FROM nscore WHERE s_no = " . $row['s_no']);
                                                    $row1 = $sql1->fetch_assoc();
                                                    $sno = $row1['sno'];
                                                    $countsno = ($cnc != 0) ? ($sno / $cnc) : 0;

                                                    if ($countsno == 1) {
                                                        echo "<td class='text-success'>ໃບ​ບິນ​ນີ້​ລົງ​ຄົບ​ຈຳ​ນວນ</td>";
                                                    } elseif ($countsno > 1) {
                                                        echo "<td class='text-primary'>ໃບ​ບິນ​ນີ້​ລົງ​ເກີນ</td>";
                                                    } else {
                                                        echo "<td class='text-danger'>ໃບ​ບິນ​ນີ້​ລົງ​ຍັງ​ບໍ່​ຄົບ</td>";
                                                    } ?>
                                                    <td><?= $row['s_no']; ?></td>
                                                    <!-- <td>
                                                        <a href="print?s_id=<?= $row['s_id']; ?>" type="button" class="btn btn-secondary" target="_blank"><i class="bi bi-printer"></i></a>
                                                        <a href="#edit_<?= $row['s_id']; ?>" type="button" class="btn btn-primary" data-bs-toggle="modal"><i class="bi bi-pencil-square"></i></a>
                                                        <a data-id="<?= $row['s_id']; ?>" href="s_action?delete=<?= $row['s_id']; ?>" type="button" class="btn btn-danger delete-btn"><i class="bi bi-trash"></i></a>
                                                    </td> -->
                                                </tr>

                                                <!-- <div class="modal fade" id="edit_<?= $row['s_id']; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">ແກ້​ໄຂໃບ​ລົງ​ຄະ​ແນນ</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="row g-3" action="s_action" method="post">
                                                                    <input type="hidden" name="s_id" value="<?= $row['s_id']; ?>">

                                                                    <div class="col-md-12">
                                                                        <label for="s_no" class="form-label">ເລກ​ທີໃບ​ລົງ​ຄະ​ແນນ</label>
                                                                        <input type="text" name="s_no" value="<?= $row['s_no']; ?>" class="form-control" required>
                                                                    </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">​ປິດ</button>
                                                                <button type="submit" name="update" class="btn btn-success">ອັບ​ເດດ​ຂໍ້​ມູນ</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div> -->

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
                                url: 's_action',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'ລົບຂໍ້ມູນສຳເລັດແລ້ວ',

                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'sheet';
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