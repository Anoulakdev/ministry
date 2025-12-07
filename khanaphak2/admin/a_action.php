<?php
session_start();
ob_start();
include '../config.php';
include '../style/sweetalert.php';
include 'status.php';


$update = false;
$a_id = "";
$a_username = "";
$a_password = "";
$a_name = "";
$a_status = "";


if (isset($_POST['add'])) {
	$a_username = $_POST['a_username'];
	$a_password = "EDL1234";
	$a_name = $_POST['a_name'];
	$a_status = 1;


	$result = $conn->query("SELECT * FROM admin WHERE a_username = '$a_username'");
	$row_cnt = $result->num_rows;

	if ($row_cnt > 0) {

		echo "<script>
			$(document).ready(function() {
			Swal.fire({
			position: 'center',
			icon: 'info',
			title: 'ຊື່ແລະລະຫັດມີຢູ່ໃນລະບົບແລ້ວ',
			showConfirmButton: false,
			timer: 3000
		  });
		});
			</script>";

		header("refresh:3; url=admin");
	} else {

		$query = "INSERT INTO admin(a_username,a_password,a_name,a_status)VALUES(?,?,?,?)";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ssss", $a_username, $a_password, $a_name, $a_status);
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

		header("refresh:3; url=admin");
	}
}
if (isset($_GET['delete'])) {
	$a_id = $_GET['delete'];


	$query = "DELETE FROM admin WHERE a_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $a_id);
	$stmt->execute();

	if ($stmt) {

		header("refresh:1; url=admin");
	}
}

if (isset($_POST['update'])) {
	$a_id = $_POST['a_id'];
	$a_username = $_POST['a_username'];
	$a_name = $_POST['a_name'];


	$query = "UPDATE admin SET a_username=?,a_name=? WHERE a_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssi", $a_username, $a_name, $a_id);
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

	header("refresh:3; url=admin");
}

if (isset($_POST['updatekill'])) {
	$s_id = $_POST['s_id'];
	$s_kill = $_POST['s_kill'];

	$query = "UPDATE sys SET s_kill=? WHERE s_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("si", $s_kill, $s_id);
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

	header("refresh:3; url=home");
}
ob_end_flush();
