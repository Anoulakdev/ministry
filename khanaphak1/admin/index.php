<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ກອງ​ປະ​ຊຸ​ມ​ພັກຮາ​ກ​ຖານ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include '../style/stylesheet.php'; ?>

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
                                    <img src="../assets/img/phak.jpg" alt="">
                                    <span>ກອງ​ປະ​ຊຸ​ມ​ພັກຮາ​ກ​ຖານ</span>
                                </div>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-3 pb-4">
                                        <h5 class="card-title text-center pb-0 fs-3"><b>ຜູ້​ດູ​ແລລະບົບ</b></h5>

                                    </div>

                                    <form action="checklogin" method="POST" class="row g-3 needs-validation"
                                        novalidate>

                                        <div class="col-12">
                                            <label for="a_username" class="form-label">ຊື່ເຂົ້າລະບົບ</label>
                                            <div class="input-group has-validation">

                                                <input type="text" name="a_username" class="form-control" required>
                                                <div class="invalid-feedback">ກະລຸນາໃສ່ຊື່ເຂົ້າລະບົບ</div>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="a_password" class="form-label">ລະຫັດ</label>
                                            <input type="password" name="a_password" class="form-control" required>
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

    <?php include '../style/script.php'; ?>

</body>

</html>