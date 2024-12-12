<?php
session_start();
ob_start();
include '../config.php';
include '../style/sweetalert.php';
include 'status.php';


$update = false;
$nc_id = "";
$nc_name = "";
$nc_age = "";
$nc_kammaban = "";
$nc_phak = "";
$nc_lat = "";
$nc_part = "";

if (isset($_POST['add'])) {
	$nc_name = $_POST['nc_name'];
	$nc_age = $_POST['nc_age'];
	$nc_kammaban = $_POST['nc_kammaban'];
	$nc_phak = $_POST['nc_phak'];
	$nc_lat = $_POST['nc_lat'];
	$nc_part = $_POST['nc_part'];

	$query = "INSERT INTO newcandidate(nc_name,nc_age,nc_kammaban,nc_phak,nc_lat,nc_part)VALUES(?,?,?,?,?,?)";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssssss", $nc_name, $nc_age, $nc_kammaban, $nc_phak, $nc_lat, $nc_part);
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

	header("refresh:3; url=newcandidate");
}

if (isset($_GET['delete'])) {
	$nc_id = $_GET['delete'];

	$query = "DELETE FROM newcandidate WHERE nc_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $nc_id);
	$stmt->execute();

	if ($stmt) {

		header("refresh:1; url=newcandidate");
	}
}

if (isset($_POST['update'])) {
	$nc_id = $_POST['nc_id'];
	$nc_name = $_POST['nc_name'];
	$nc_age = $_POST['nc_age'];
	$nc_kammaban = $_POST['nc_kammaban'];
	$nc_phak = $_POST['nc_phak'];
	$nc_lat = $_POST['nc_lat'];
	$nc_part = $_POST['nc_part'];

	$query = "UPDATE newcandidate SET nc_name=?, nc_age=?, nc_kammaban=?, nc_phak=?, nc_lat=?, nc_part=? WHERE nc_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssssssi", $nc_name, $nc_age, $nc_kammaban, $nc_phak, $nc_lat, $nc_part, $nc_id);
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

	header("refresh:3; url=newcandidate");
}

ob_end_flush();
