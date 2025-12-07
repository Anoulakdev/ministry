<?php
session_start();
ob_start();
include '../config.php';
include '../style/sweetalert.php';
include 'status.php';


$update = false;
$m_id = "";
$m_username = "";
$m_password = "";
$m_status = "";


if (isset($_POST['add'])) {
    $m_username = $_POST['m_username'];
    $m_password = $_POST['m_password'];
    $m_status = 1;

    $result = $conn->query("SELECT * FROM member WHERE m_username = '$m_username'");
    $row_cnt = $result->num_rows;

    if ($row_cnt > 0) {

        echo "<script>
			$(document).ready(function() {
			Swal.fire({
			position: 'center',
			icon: 'info',
			title: 'ຊື່ມີຢູ່ໃນລະບົບແລ້ວ',
			showConfirmButton: false,
			timer: 3000
		  });
		});
			</script>";

        header("refresh:3; url=member");
    } else {

        $query = "INSERT INTO member(m_username,m_password,m_status)VALUES(?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $m_username, $m_password, $m_status);
        $stmt->execute();

        echo "<script>
			$(document).ready(function() {
				Swal.fire({
					position: 'center',
					icon: 'success',
					title: 'ເພີ່ມຂໍ້​ມູນເຂົ້າລະບົບສຳເລັດແລ້ວ',
					showConfirmButton: false,
					timer: 3000
				  });
			});
		</script>";

        header("refresh:3; url=member");
    }
}

if (isset($_GET['delete'])) {
    $m_id = $_GET['delete'];

    $query = "DELETE FROM member WHERE m_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $m_id);
    $stmt->execute();

    if ($stmt) {

        header("refresh:1; url=member");
    }
}

if (isset($_POST['update'])) {
    $m_id = $_POST['m_id'];
    $m_username = $_POST['m_username'];
    $m_password = $_POST['m_password'];

    $query = "UPDATE member SET m_username=?, m_password=? WHERE m_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $m_username, $m_password, $m_id);
    $stmt->execute();

    echo "<script>
				$(document).ready(function() {
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'ອັບເດດຂໍ້ມູນສຳເລັດແລ້ວ',
						showConfirmButton: false,
						timer: 3000
					  });
				});
			</script>";

    header("refresh:3; url=member");
}


if (isset($_GET['deleteall'])) {
    $m_id = $_GET['deleteall'];

    $query = "DELETE FROM nscore WHERE m_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $m_id);
    $stmt->execute();

    if ($stmt) {

        header("refresh:1; url=memberdelete");
    }
}

ob_end_flush();
