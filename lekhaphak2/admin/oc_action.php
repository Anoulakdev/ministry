<?php
session_start();
ob_start();
include '../config.php';
include '../style/sweetalert.php';
include 'status.php';


$update = false;
$oc_id = "";
$oc_name = "";
$oc_pic = "";



if (isset($_POST['add'])) {
	$oc_name = $_POST['oc_name'];

	if (isset($_FILES['oc_pic']['name']) && ($_FILES['oc_pic']['name'] != "")) {

		$dn = date('ymdHis');
		$oc_pic = $_FILES['oc_pic']['name'];
		$extension = pathinfo($oc_pic, PATHINFO_EXTENSION);
		$randomno = rand(0, 10000);
		$pic_rand = $dn . $randomno . '.' . $extension;
		$upicture = "../uploads/candidate/" . $pic_rand;
	} else {

		$pic_rand = "";
		$upicture = "";
	}

	$result = $conn->query("SELECT MAX(oc_id) as last_id FROM oldcandidate");
	$row = $result->fetch_assoc();

	if ($row['last_id'] === null) {
		$next_id = 1;
	} else {
		$next_id = $row['last_id'] + 1;
	}

	$query = "INSERT INTO oldcandidate(oc_id, oc_name, oc_pic) VALUES(?,?,?)";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("iss", $next_id, $oc_name, $pic_rand);
	$stmt->execute();
	move_uploaded_file($_FILES['oc_pic']['tmp_name'], $upicture);

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

	$sql = "SELECT oc_pic FROM oldcandidate WHERE oc_id=?";
	$stmt2 = $conn->prepare($sql);
	$stmt2->bind_param("i", $oc_id);
	$stmt2->execute();
	$result2 = $stmt2->get_result();
	$row = $result2->fetch_assoc();

	$imagepath = "../uploads/candidate/" . $row['oc_pic'];
	unlink($imagepath);

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
	$oldpic = $_POST['oldpic'];

	if (isset($_FILES['oc_pic']['name']) && ($_FILES['oc_pic']['name'] != "")) {
		$dn = date('ymdHis');
		$oc_pic = $_FILES['oc_pic']['name'];
		$extension = pathinfo($oc_pic, PATHINFO_EXTENSION);
		$randomno = rand(0, 10000);
		$pic_rand = $dn . $randomno . '.' . $extension;
		$upicture = "../uploads/candidate/" . $pic_rand;

		$noc_pic = $pic_rand;
		if ($oldpic != "") {
			unlink("../uploads/candidate/" . $oldpic);
		}
		move_uploaded_file($_FILES['oc_pic']['tmp_name'], $upicture);
	} else {

		$noc_pic = $oldpic;
	}


	$query = "UPDATE oldcandidate SET oc_name=?, oc_pic=? WHERE oc_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssi", $oc_name, $noc_pic, $oc_id);
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
