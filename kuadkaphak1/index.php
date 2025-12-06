<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ກອງ​ປະ​ຊຸ​ມ​ພັກຮາ​ກ​ຖານ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="assets/img/phak.jpg" rel="icon">


    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

    <main>
        <div class="container">

            <section class="section register d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-5">
                                <div class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/phak.jpg" alt="" class="me-2">
                                    <span>ກອງ​ປະ​ຊຸ​ມ​ພັກຮາ​ກ​ຖານ</span>
                                </div>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-3 pb-4">
                                        <h5 class="card-title text-center pb-0 fs-3"><b>ເຂົ້າລະບົບ</b></h5>

                                    </div>

                                    <form action="member/checklogin" method="POST" class="row g-3 needs-validation"
                                        novalidate>

                                        <div class="col-12">
                                            <label for="m_username" class="form-label">ຊື່ເຂົ້າລະບົບ</label>
                                            <div class="input-group has-validation">

                                                <input type="text" name="m_username" class="form-control" required>
                                                <div class="invalid-feedback">ກະລຸນາໃສ່ຊື່ເຂົ້າລະບົບ</div>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="m_password" class="form-label">ລະຫັດ</label>
                                            <input type="text" name="m_password" class="form-control" required>
                                            <div class="invalid-feedback">ກະລຸນາໃສ່ລະຫັດ</div>
                                        </div>


                                        <div class="col-12 pb-4">
                                            <button class="btn btn-primary w-100" type="submit">ເຂົ້າລະບົບ</button>
                                        </div>

                                    </form>

                                </div>
                            </div>



                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>