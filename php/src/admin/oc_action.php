<?php
session_start();
ob_start();
include '../config.php';
include '../style/sweetalert.php';
include 'status.php';


$update = false;
$oc_id = "";
$oc_name = "";
$oc_age = "";
$oc_kammaban = "";
$oc_phak = "";
$oc_lat = "";
$oc_part = "";

if (isset($_POST['add'])) {
	$oc_name = $_POST['oc_name'];
	$oc_age = $_POST['oc_age'];
	$oc_kammaban = $_POST['oc_kammaban'];
	$oc_phak = $_POST['oc_phak'];
	$oc_lat = $_POST['oc_lat'];
	$oc_part = $_POST['oc_part'];

	$query = "INSERT INTO oldcandidate(oc_name,oc_age,oc_kammaban,oc_phak,oc_lat,oc_part)VALUES(?,?,?,?,?,?)";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssssss", $oc_name, $oc_age, $oc_kammaban, $oc_phak, $oc_lat, $oc_part);
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

	header("refresh:3; url=oldcandidate");
}

if (isset($_GET['delete'])) {
	$oc_id = $_GET['delete'];

	$query = "DELETE FROM oldcandidate WHERE oc_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $oc_id);
	$stmt->execute();

	if ($stmt) {

		header("refresh:1; url=oldcandidate");
	}
}

if (isset($_POST['update'])) {
	$oc_id = $_POST['oc_id'];
	$oc_name = $_POST['oc_name'];
	$oc_age = $_POST['oc_age'];
	$oc_kammaban = $_POST['oc_kammaban'];
	$oc_phak = $_POST['oc_phak'];
	$oc_lat = $_POST['oc_lat'];
	$oc_part = $_POST['oc_part'];

	$query = "UPDATE oldcandidate SET oc_name=?, oc_age=?, oc_kammaban=?, oc_phak=?, oc_lat=?, oc_part=? WHERE oc_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssssssi", $oc_name, $oc_age, $oc_kammaban, $oc_phak, $oc_lat, $oc_part, $oc_id);
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

	header("refresh:3; url=oldcandidate");
}

ob_end_flush();
