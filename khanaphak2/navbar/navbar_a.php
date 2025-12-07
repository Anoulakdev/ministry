<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <div href="index.html" class="logo d-flex align-items-center">
            <img src="../assets/img/phak.jpg" alt="">
            <span class="d-none d-lg-block fs-5">ກອງ​ປະ​ຊຸ​ມ​ພັກຮາ​ກ​ຖານ</span>
        </div>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="../assets/img/profile-picture.jpg" alt="Profile" class="rounded-circle">
                    <span class="d-md-block dropdown-toggle ps-2"><?= $_SESSION['a_name']; ?></span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="logout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>ອອກ​ລະ​ບົບ</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->