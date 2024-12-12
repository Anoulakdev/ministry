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

    $sql1 = "SELECT max(m_id) as mid FROM member";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
    $mid = $row1['mid'];

    $count = 100001;
    if ($row1['mid'] == "NULL") {
        $username = $count;
    } else {
        $username = $mid + $count;
    }

    $randomno = rand(1000000, 10000000);

    $m_username = $username;
    $m_password = $randomno;
    $m_status = 1;


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
					timer: 1000
				  });
			});
		</script>";

    header("refresh:1; url=member");
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
    $m_password = $_POST['m_password'];

    $query = "UPDATE member SET m_password=? WHERE m_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $m_password, $m_id);
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

    $query = "DELETE FROM oscore WHERE m_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $m_id);
    $stmt->execute();

    $query1 = "DELETE FROM nscore WHERE m_id=?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("i", $m_id);
    $stmt1->execute();

    if ($stmt && $stmt1) {

        header("refresh:1; url=memberdelete");
    }
}

ob_end_flush();
