<?php
session_start();
ob_start();
include '../style/sweetalert.php';

if (isset($_POST['m_username'])) {

  include("../config.php");

  $m_username = $conn->real_escape_string($_POST['m_username']);

  $m_password = $conn->real_escape_string($_POST['m_password']);



  $sql = "SELECT * FROM member 

                  WHERE  m_username='" . $m_username . "' 

                  AND  m_password='" . $m_password . "' ";

  $result = $conn->query($sql);



  if (mysqli_num_rows($result) == 1) {

    $row = $result->fetch_assoc();



    $_SESSION["m_id"] = $row["m_id"];

    $_SESSION["m_username"] = $row["m_username"];

    $_SESSION["m_password"] = $row["m_password"];

    $_SESSION["m_status"] = $row["m_status"];


    if ($_SESSION["m_status"] == "1") {

      Header("Location: oaddscore");
    }
  } else {



    echo "<script>

                          $(document).ready(function() {

                            Swal.fire({

                              position: 'center',

                              icon: 'info',

                              title: 'ຊື່ ແລະ ລະຫັດ ບໍ່ຖືກຕ້ອງ',

                              showConfirmButton: false,

                              timer: 3000

                              });

                          });

                        </script>";



    header("refresh:3; url=../index");
  }
} else {



  Header("Location: ../index"); //user & password incorrect back to login again



}
ob_end_flush();
