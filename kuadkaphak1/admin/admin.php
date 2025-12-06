<?php include 'a_action.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ຜູ້​ດູ​ແລລະບົບ</title>
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

        <div class="pagetitle py-2">
            <h1>ຜູ້​ດູ​ແລລະບົບ</h1>

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
                                            <h5 class="modal-title">ເພີ່ມຜູ້​ດູ​ແລລະບົບ</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row g-3" action="a_action" method="post">
                                                <div class="col-md-12">
                                                    <label for="a_username" class="form-label">ຊື່​ເຂົ້າ​ລະ​ບົບ</label>
                                                    <input type="text" name="a_username" class="form-control" required>
                                                </div>
                                                <!-- <div class="col-md-12">
                                                    <label for="a_password" class="form-label">ລະ​ຫັດ</label>
                                                    <input type="text" name="a_password" class="form-control" required>
                                                </div> -->
                                                <div class="col-md-12">
                                                    <label for="a_name" class="form-label">ຊື່</label>
                                                    <input type="text" name="a_name" class="form-control" required>
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

                            <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addModal">
                                ເພີ່ມຜູ້​ດູ​ແລລະບົບ
                            </button>

                            <?php
                            $query = "SELECT * FROM admin WHERE NOT a_id = '". $_SESSION['a_id'] ."'";
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
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ລ/ດ</th>
                                            <th>ຊື່​ເຂົ້າ​ລະ​ບົບ</th>
                                            <!-- <th>​ລະ​ຫັດ</th> -->
                                            <th>​ຊື່</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($data as $row) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $row['a_username']; ?></td>
                                                <!-- <td><?= $row['a_password']; ?></td> -->
                                                <td><?= $row['a_name']; ?></td>
                                                <td>
                                                    <a href="#edit_<?= $row['a_id']; ?>" type="button" class="btn btn-primary" data-bs-toggle="modal"><i class="bi bi-pencil-square"></i></a>
                                                    <a data-id="<?= $row['a_id']; ?>" href="a_action?delete=<?= $row['a_id']; ?>" type="button" class="btn btn-danger delete-btn"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="edit_<?= $row['a_id']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">ແກ້​ໄຂຜູ້​ດູ​ແລລະບົບ</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="row g-3" action="a_action" method="post">
                                                                <input type="hidden" name="a_id" value="<?= $row['a_id']; ?>">
                                                                <div class="col-md-12">
                                                                    <label for="a_username" class="form-label">ຊື່​ເຂົ້າ​ລະ​ບົບ</label>
                                                                    <input type="text" name="a_username" value="<?= $row['a_username']; ?>" class="form-control" required>
                                                                </div>
                                                                <!-- <div class="col-md-12">
                                                                    <label for="a_password" class="form-label">ລະ​ຫັດ</label>
                                                                    <input type="text" name="a_password" value="<?= $row['a_password']; ?>" class="form-control" required>
                                                                </div> -->
                                                                <div class="col-md-12">
                                                                    <label for="a_name" class="form-label">ຊື່</label>
                                                                    <input type="text" name="a_name" value="<?= $row['a_name']; ?>" class="form-control" required>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">​ປິດ</button>
                                                            <button type="submit" name="update" class="btn btn-success">ອັບ​ເດດ​ຂໍ້​ມູນ</button>
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

    </main><!-- End #main -->



    <?php include '../style/script.php'; ?>

    <script>
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
                                url: 'a_action',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'ລົບຂໍ້ມູນສຳເລັດແລ້ວ',

                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'admin';
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