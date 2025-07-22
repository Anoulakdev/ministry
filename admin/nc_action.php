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
$nc_phak = "";
$nc_lat = "";
$nc_women = "";
$nc_part = "";
$nc_reason = "";
$nc_pic = "";



if (isset($_POST['add'])) {
	$nc_name = $_POST['nc_name'];
	$nc_age = $_POST['nc_age'];
	$nc_phak = $_POST['nc_phak'];
	$nc_lat = $_POST['nc_lat'];
	$nc_women = $_POST['nc_women'];
	$nc_part = $_POST['nc_part'];
	$nc_reason = $_POST['nc_reason'];

	if (isset($_FILES['nc_pic']['name']) && ($_FILES['nc_pic']['name'] != "")) {

		$dn = date('ymdHis');
		$nc_pic = $_FILES['nc_pic']['name'];
		$extension = pathinfo($nc_pic, PATHINFO_EXTENSION);
		$randomno = rand(0, 10000);
		$pic_rand = $dn . $randomno . '.' . $extension;
		$upicture = "../uploads/candidate/" . $pic_rand;
	} else {

		$pic_rand = "";
		$upicture = "";
	}

	$query = "INSERT INTO newcandidate(nc_name,nc_age,nc_phak,nc_lat,nc_women,nc_part,nc_reason,nc_pic)VALUES(?,?,?,?,?,?,?,?)";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssssssss", $nc_name, $nc_age, $nc_phak, $nc_lat, $nc_women, $nc_part, $nc_reason, $pic_rand);
	$stmt->execute();
	move_uploaded_file($_FILES['nc_pic']['tmp_name'], $upicture);

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

	$sql = "SELECT nc_pic FROM newcandidate WHERE nc_id=?";
	$stmt2 = $conn->prepare($sql);
	$stmt2->bind_param("i", $nc_id);
	$stmt2->execute();
	$result2 = $stmt2->get_result();
	$row = $result2->fetch_assoc();

	$imagepath = "../uploads/candidate/" . $row['nc_pic'];
	unlink($imagepath);

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
	$nc_phak = $_POST['nc_phak'];
	$nc_lat = $_POST['nc_lat'];
	$nc_women = $_POST['nc_women'];
	$nc_part = $_POST['nc_part'];
	$nc_reason = $_POST['nc_reason'];
	$oldpic = $_POST['oldpic'];

	if (isset($_FILES['nc_pic']['name']) && ($_FILES['nc_pic']['name'] != "")) {
		$dn = date('ymdHis');
		$nc_pic = $_FILES['nc_pic']['name'];
		$extension = pathinfo($nc_pic, PATHINFO_EXTENSION);
		$randomno = rand(0, 10000);
		$pic_rand = $dn . $randomno . '.' . $extension;
		$upicture = "../uploads/candidate/" . $pic_rand;

		$nnc_pic = $pic_rand;
		if ($oldpic != "") {
			unlink("../uploads/candidate/" . $oldpic);
		}
		move_uploaded_file($_FILES['nc_pic']['tmp_name'], $upicture);
	} else {

		$nnc_pic = $oldpic;
	}


	$query = "UPDATE newcandidate SET nc_name=?, nc_age=?, nc_phak=?, nc_lat=?, nc_women=?, nc_part=?, nc_reason=?, nc_pic=? WHERE nc_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssssssssi", $nc_name, $nc_age, $nc_phak, $nc_lat, $nc_women, $nc_part, $nc_reason, $nnc_pic, $nc_id);
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
