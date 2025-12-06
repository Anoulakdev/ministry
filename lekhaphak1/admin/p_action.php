<?php
session_start();
ob_start();
include '../config.php';
include '../style/sweetalert.php';
include 'status.php';


$update = false;
$oc1_id = "";
$oc1_name = "";
$oc1_pic = "";
$nc1_id = "";
$nc1_name = "";
$nc1_pic = "";



if (isset($_POST['add1'])) {
	$oc1_name = $_POST['oc1_name'];

	if (isset($_FILES['oc1_pic']['name']) && ($_FILES['oc1_pic']['name'] != "")) {

		$dn = date('ymdHis');
		$oc1_pic = $_FILES['oc1_pic']['name'];
		$extension = pathinfo($oc1_pic, PATHINFO_EXTENSION);
		$randomno = rand(0, 10000);
		$pic_rand = $dn . $randomno . '.' . $extension;
		$upicture = "../uploads/candidate/" . $pic_rand;
	} else {

		$pic_rand = "";
		$upicture = "";
	}

	$result = $conn->query("SELECT MAX(oc1_id) as last_id FROM oldcandidate1");
	$row = $result->fetch_assoc();

	if ($row['last_id'] === null) {
		$next_id = 1;
	} else {
		$next_id = $row['last_id'] + 1;
	}

	$query = "INSERT INTO oldcandidate1(oc1_id, oc1_name, oc1_pic) VALUES(?,?,?)";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("iss", $next_id, $oc1_name, $pic_rand);
	$stmt->execute();
	move_uploaded_file($_FILES['oc1_pic']['tmp_name'], $upicture);

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

	header("refresh:3; url=president");
}

if (isset($_GET['delete1'])) {
	$oc1_id = $_GET['delete1'];

	$sql = "SELECT oc1_pic FROM oldcandidate1 WHERE oc1_id=?";
	$stmt2 = $conn->prepare($sql);
	$stmt2->bind_param("i", $oc1_id);
	$stmt2->execute();
	$result2 = $stmt2->get_result();
	$row = $result2->fetch_assoc();

	if (!empty($row['oc1_pic'])) { // ถ้ามีชื่อไฟล์
		$imagepath = "../uploads/candidate/" . $row['oc1_pic'];

		if (file_exists($imagepath)) { // ถ้าไฟล์มีจริง
			unlink($imagepath);
		}
	}

	$query = "DELETE FROM oldcandidate1 WHERE oc1_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $oc1_id);
	$stmt->execute();

	header("Location: president");
	exit();
}

if (isset($_POST['update1'])) {
	$oc1_id = $_POST['oc1_id'];
	$oc1_name = $_POST['oc1_name'];
	$oldpic = $_POST['oldpic'];

	if (isset($_FILES['oc1_pic']['name']) && ($_FILES['oc1_pic']['name'] != "")) {
		$dn = date('ymdHis');
		$oc1_pic = $_FILES['oc1_pic']['name'];
		$extension = pathinfo($oc1_pic, PATHINFO_EXTENSION);
		$randomno = rand(0, 10000);
		$pic_rand = $dn . $randomno . '.' . $extension;
		$upicture = "../uploads/candidate/" . $pic_rand;

		$noc1_pic = $pic_rand;
		if ($oldpic != "") {
			unlink("../uploads/candidate/" . $oldpic);
		}
		move_uploaded_file($_FILES['oc1_pic']['tmp_name'], $upicture);
	} else {

		$noc1_pic = $oldpic;
	}


	$query = "UPDATE oldcandidate1 SET oc1_name=?, oc1_pic=? WHERE oc1_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssi", $oc1_name, $noc1_pic, $oc1_id);
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

	header("refresh:3; url=president");
}

// ----------------- Old Candidate 2 -----------------

if (isset($_POST['add2'])) {
	$nc1_name = $_POST['nc1_name'];

	if (isset($_FILES['nc1_pic']['name']) && ($_FILES['nc1_pic']['name'] != "")) {

		$dn = date('ymdHis');
		$nc1_pic = $_FILES['nc1_pic']['name'];
		$extension = pathinfo($nc1_pic, PATHINFO_EXTENSION);
		$randomno = rand(0, 10000);
		$pic_rand = $dn . $randomno . '.' . $extension;
		$upicture = "../uploads/candidate/" . $pic_rand;
	} else {

		$pic_rand = "";
		$upicture = "";
	}

	$result = $conn->query("SELECT MAX(nc1_id) as last_id FROM newcandidate1");
	$row = $result->fetch_assoc();

	if ($row['last_id'] === null) {
		$next_id = 1;
	} else {
		$next_id = $row['last_id'] + 1;
	}

	$query = "INSERT INTO newcandidate1(nc1_id, nc1_name, nc1_pic) VALUES(?,?,?)";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("iss", $next_id, $nc1_name, $pic_rand);
	$stmt->execute();
	move_uploaded_file($_FILES['nc1_pic']['tmp_name'], $upicture);

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

	header("refresh:3; url=president");
}

if (isset($_GET['delete2'])) {
	$nc1_id = $_GET['delete2'];

	$sql = "SELECT nc1_pic FROM newcandidate1 WHERE nc1_id=?";
	$stmt2 = $conn->prepare($sql);
	$stmt2->bind_param("i", $nc1_id);
	$stmt2->execute();
	$result2 = $stmt2->get_result();
	$row = $result2->fetch_assoc();

	if (!empty($row['nc1_pic'])) { // ถ้ามีชื่อไฟล์
		$imagepath = "../uploads/candidate/" . $row['nc1_pic'];

		if (file_exists($imagepath)) { // ถ้าไฟล์มีจริง
			unlink($imagepath);
		}
	}

	$query = "DELETE FROM newcandidate1 WHERE nc1_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $nc1_id);
	$stmt->execute();

	header("Location: president");
	exit();
}

if (isset($_POST['update2'])) {
	$nc1_id = $_POST['nc1_id'];
	$nc1_name = $_POST['nc1_name'];
	$oldpic = $_POST['oldpic'];

	if (isset($_FILES['nc1_pic']['name']) && ($_FILES['nc1_pic']['name'] != "")) {
		$dn = date('ymdHis');
		$nc1_pic = $_FILES['nc1_pic']['name'];
		$extension = pathinfo($nc1_pic, PATHINFO_EXTENSION);
		$randomno = rand(0, 10000);
		$pic_rand = $dn . $randomno . '.' . $extension;
		$upicture = "../uploads/candidate/" . $pic_rand;

		$nnc1_pic = $pic_rand;
		if ($oldpic != "") {
			unlink("../uploads/candidate/" . $oldpic);
		}
		move_uploaded_file($_FILES['nc1_pic']['tmp_name'], $upicture);
	} else {

		$nnc1_pic = $oldpic;
	}


	$query = "UPDATE newcandidate1 SET nc1_name=?, nc1_pic=? WHERE nc1_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssi", $nc1_name, $nnc1_pic, $nc1_id);
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

	header("refresh:3; url=president");
}
ob_end_flush();
