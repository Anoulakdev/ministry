<?php include 'dp_action.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ຜູ້​ສະ​ໝັກຮອງເຂາ</title>
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
                <h1>ຜູ້​ສະ​ໝັກຮອງເລຂາ</h1>

            </div><!-- End Page Title -->

            <section class="section">
                <div class="row">
                    <div class="col-md-6">

                        <div class="card">
                            <div class="card-body">

                                <div class="modal fade" id="addModal1" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">ເພີ່ມຜູ້ສະ​ໝັກ</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="row g-3" action="dp_action" method="post" enctype="multipart/form-data">

                                                    <div class="col-md-12">
                                                        <label for="oc2_name" class="form-label">ຊື່ ແລະ ນາມ​ສະ​ກຸນ</label>
                                                        <input type="text" name="oc2_name" class="form-control">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="oc2_pic" class="form-label">ຮູບ​ພາບ</label>
                                                        <input type="file" name="oc2_pic" class="form-control">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">​ປິດ</button>
                                                <button type="submit" name="add1" class="btn btn-primary">ເພີ່ມ​ຂໍ້​ມູນ</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <h2 class="mt-3">ຄະ​ນະ​ຊຸດ​ເກົ່າ</h2>

                                <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addModal1">
                                    ເພີ່ມຜູ້ສະ​ໝັກ
                                </button>

                                <?php
                                $query = "SELECT * FROM oldcandidate2";
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
                                    <table class="table" id="example1">
                                        <thead class="table-light text-center align-middle">
                                            <tr>
                                                <th>ລ/ດ</th>
                                                <th>ຮູບ​ພາບ</th>
                                                <th>​ຊື່ ແລະ ນາມ​ສະ​ກຸນ</th>
                                                <th>#</th>
                                            </tr>

                                        </thead>
                                        <tbody class="text-center align-middle">
                                            <?php $i = 1; ?>
                                            <?php foreach ($data as $row) { ?>
                                                <tr>
                                                    <td><?= $row['oc2_id']; ?></td>
                                                    <td>
                                                        <?php if ($row['oc2_pic'] != "") { ?>
                                                            <img src="../uploads/candidate/<?= $row['oc2_pic']; ?>" width="60" height="65" class="rounded-circle">
                                                        <?php } else { ?>
                                                            <img src="../assets/img/profile-picture.jpg" alt="Profile" width="60" height="65" class="rounded-circle">
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-start"><?= $row['oc2_name']; ?></td>
                                                    <td>
                                                        <a href="#edit1_<?= $row['oc2_id']; ?>" type="button" class="btn btn-primary" data-bs-toggle="modal"><i class="bi bi-pencil-square"></i></a>
                                                        <a
                                                            href="dp_action?delete1=<?= $row['oc2_id']; ?>"
                                                            class="btn btn-danger"
                                                            onclick="return confirm('ແນ່ໃຈບໍທີ່ຈະລຶບລາຍການນີ້?');">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <div class="modal fade" id="edit1_<?= $row['oc2_id']; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">ແກ້​ໄຂຜູ້ສະ​ໝັກ</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="row g-3" action="dp_action" method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="oc2_id" value="<?= $row['oc2_id']; ?>">

                                                                    <div class="col-md-12">
                                                                        <label for="oc2_name" class="form-label">ຊື່ຜູ້​ສະ​ໝັກ</label>
                                                                        <input type="text" name="oc2_name" value="<?= $row['oc2_name']; ?>" class="form-control">
                                                                    </div>
                                                                    <div class="col-md-12 mt-2">
                                                                        <label for="oc2_pic" class="form-label">ຮູບ​ພາບ</label>
                                                                        <input type="hidden" name="oldpic" value="<?= $row['oc2_pic']; ?>">
                                                                        <input type="file" name="oc2_pic" class="form-control mb-2">
                                                                        <?php if ($row['oc2_pic'] != "") { ?>
                                                                            <img src="../uploads/candidate/<?= $row['oc2_pic']; ?>" width="120" class="rounded-circle">
                                                                        <?php } else { ?>
                                                                            <img src="../assets/img/profile-picture.jpg" alt="Profile" width="120" class="rounded-circle">
                                                                        <?php } ?>

                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">​ປິດ</button>
                                                                <button type="submit" name="update1" class="btn btn-success">ອັບ​ເດດ​ຂໍ້​ມູນ</button>
                                                            </div>
                                                            </form>
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

                    <!-- --------------------------- Second Column --------------------------- -->

                    <div class="col-md-6">

                        <div class="card">
                            <div class="card-body">

                                <div class="modal fade" id="addModal2" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">ເພີ່ມຜູ້ສະ​ໝັກ</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="row g-3" action="dp_action" method="post" enctype="multipart/form-data">

                                                    <div class="col-md-12">
                                                        <label for="nc2_name" class="form-label">ຊື່ ແລະ ນາມ​ສະ​ກຸນ</label>
                                                        <input type="text" name="nc2_name" class="form-control">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="nc2_pic" class="form-label">ຮູບ​ພາບ</label>
                                                        <input type="file" name="nc2_pic" class="form-control">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">​ປິດ</button>
                                                <button type="submit" name="add2" class="btn btn-primary">ເພີ່ມ​ຂໍ້​ມູນ</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <h2 class="mt-3">ເປົ້າ​ໝາຍ​ໃໝ່</h2>

                                <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addModal2">
                                    ເພີ່ມຜູ້ສະ​ໝັກ
                                </button>

                                <?php
                                $query = "SELECT * FROM newcandidate2";
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
                                    <table class="table" id="example2">
                                        <thead class="table-light text-center align-middle">
                                            <tr>
                                                <th>ລ/ດ</th>
                                                <th>ຮູບ​ພາບ</th>
                                                <th>​ຊື່ ແລະ ນາມ​ສະ​ກຸນ</th>
                                                <th>#</th>
                                            </tr>

                                        </thead>
                                        <tbody class="text-center align-middle">
                                            <?php $i = 1; ?>
                                            <?php foreach ($data as $row) { ?>
                                                <tr>
                                                    <td><?= $row['nc2_id']; ?></td>
                                                    <td>
                                                        <?php if ($row['nc2_pic'] != "") { ?>
                                                            <img src="../uploads/candidate/<?= $row['nc2_pic']; ?>" width="60" height="65" class="rounded-circle">
                                                        <?php } else { ?>
                                                            <img src="../assets/img/profile-picture.jpg" alt="Profile" width="60" height="65" class="rounded-circle">
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-start"><?= $row['nc2_name']; ?></td>
                                                    <td>
                                                        <a href="#edit2_<?= $row['nc2_id']; ?>" type="button" class="btn btn-primary" data-bs-toggle="modal"><i class="bi bi-pencil-square"></i></a>
                                                        <a
                                                            href="dp_action?delete2=<?= $row['nc2_id']; ?>"
                                                            class="btn btn-danger"
                                                            onclick="return confirm('ແນ່ໃຈບໍທີ່ຈະລຶບລາຍການນີ້?');">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <div class="modal fade" id="edit2_<?= $row['nc2_id']; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">ແກ້​ໄຂຜູ້ສະ​ໝັກ</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="row g-3" action="dp_action" method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="nc2_id" value="<?= $row['nc2_id']; ?>">

                                                                    <div class="col-md-12">
                                                                        <label for="nc2_name" class="form-label">ຊື່ຜູ້​ສະ​ໝັກ</label>
                                                                        <input type="text" name="nc2_name" value="<?= $row['nc2_name']; ?>" class="form-control">
                                                                    </div>
                                                                    <div class="col-md-12 mt-2">
                                                                        <label for="nc2_pic" class="form-label">ຮູບ​ພາບ</label>
                                                                        <input type="hidden" name="oldpic" value="<?= $row['nc2_pic']; ?>">
                                                                        <input type="file" name="nc2_pic" class="form-control mb-2">
                                                                        <?php if ($row['nc2_pic'] != "") { ?>
                                                                            <img src="../uploads/candidate/<?= $row['nc2_pic']; ?>" width="120" class="rounded-circle">
                                                                        <?php } else { ?>
                                                                            <img src="../assets/img/profile-picture.jpg" alt="Profile" width="120" class="rounded-circle">
                                                                        <?php } ?>

                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">​ປິດ</button>
                                                                <button type="submit" name="update2" class="btn btn-success">ອັບ​ເດດ​ຂໍ້​ມູນ</button>
                                                            </div>
                                                            </form>
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
            ['#example1', '#example2'].forEach(id => {
                const table = $(id).DataTable({
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
                    responsive: false,
                    lengthChange: true,
                    autoWidth: false,
                });

                // ⭐ Dynamic append ปุ่มให้ตรงกับ table ID ⭐
                table.buttons().container().appendTo(`${id}_wrapper .col-md-6:eq(0)`);
            });
        });
    </script>

</body>

</html>