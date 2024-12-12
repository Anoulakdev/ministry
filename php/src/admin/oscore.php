<?php
session_start();
ob_start();
include 'status.php';
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ຜົນ​ຄະ​ແນນ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include '../style/stylesheet.php'; ?>

</head>

<body onload="table();">

    <!-- ======= Header ======= -->
    <?php include '../navbar/navbar_a.php'; ?>

    <!-- ======= Sidebar ======= -->
    <?php include '../sidebar/sidebar_a.php'; ?>

    <main id="main" class="main">
        <div class="container-fluid">

            <section class="section">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <div class="row p-3">
                                    <div class="d-flex justify-content-between">
                                        <h1 class="text-decoration-underline text-primary">ຜົນ​ຄະ​ແນນ</h1>
                                        <h1 class="text-success" id="bill"></h1>
                                    </div>
                                </div>
                                <div id="table">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main><!-- End #main -->



    <?php include '../style/script.php'; ?>

    <script type="text/javascript">
        function table() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("table").innerHTML = this.responseText;

            }
            xhttp.open("GET", "oscore_table");
            xhttp.send();
        }

        setInterval(function() {
            table();
        }, 2000);


        function bill() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("bill").innerHTML = this.responseText;

            }
            xhttp.open("GET", "ocounts");
            xhttp.send();
        }

        setInterval(function() {
            bill();
        }, 2000);
    </script>


</body>

</html>