<?php
session_start();
ob_start();
include '../config.php';
include '../style/sweetalert.php';
include 'status.php';


$update = false;
$oc2_id = "";
$oc2_name = "";
$oc2_pic = "";
$nc2_id = "";
$nc2_name = "";
$nc2_pic = "";



if (isset($_POST['add1'])) {
	$oc2_name = $_POST['oc2_name'];

	if (isset($_FILES['oc2_pic']['name']) && ($_FILES['oc2_pic']['name'] != "")) {

		$dn = date('ymdHis');
		$oc2_pic = $_FILES['oc2_pic']['name'];
		$extension = pathinfo($oc2_pic, PATHINFO_EXTENSION);
		$randomno = rand(0, 10000);
		$pic_rand = $dn . $randomno . '.' . $extension;
		$upicture = "../uploads/candidate/" . $pic_rand;
	} else {

		$pic_rand = "";
		$upicture = "";
	}

	$result = $conn->query("SELECT MAX(oc2_id) as last_id FROM oldcandidate2");
	$row = $result->fetch_assoc();

	if ($row['last_id'] === null) {
		$next_id = 1;
	} else {
		$next_id = $row['last_id'] + 1;
	}

	$query = "INSERT INTO oldcandidate2(oc2_id, oc2_name, oc2_pic) VALUES(?,?,?)";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("iss", $next_id, $oc2_name, $pic_rand);
	$stmt->execute();
	move_uploaded_file($_FILES['oc2_pic']['tmp_name'], $upicture);

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

	header("refresh:3; url=deputypresident");
}

if (isset($_GET['delete1'])) {
	$oc2_id = $_GET['delete1'];

	$sql = "SELECT oc2_pic FROM oldcandidate2 WHERE oc2_id=?";
	$stmt2 = $conn->prepare($sql);
	$stmt2->bind_param("i", $oc2_id);
	$stmt2->execute();
	$result2 = $stmt2->get_result();
	$row = $result2->fetch_assoc();

	if (!empty($row['oc2_pic'])) { // ถ้ามีชื่อไฟล์
		$imagepath = "../uploads/candidate/" . $row['oc2_pic'];

		if (file_exists($imagepath)) { // ถ้าไฟล์มีจริง
			unlink($imagepath);
		}
	}

	$query = "DELETE FROM oldcandidate2 WHERE oc2_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $oc2_id);
	$stmt->execute();

	header("Location: deputypresident");
	exit();
}

if (isset($_POST['update1'])) {
	$oc2_id = $_POST['oc2_id'];
	$oc2_name = $_POST['oc2_name'];
	$oldpic = $_POST['oldpic'];

	if (isset($_FILES['oc2_pic']['name']) && ($_FILES['oc2_pic']['name'] != "")) {
		$dn = date('ymdHis');
		$oc2_pic = $_FILES['oc2_pic']['name'];
		$extension = pathinfo($oc2_pic, PATHINFO_EXTENSION);
		$randomno = rand(0, 10000);
		$pic_rand = $dn . $randomno . '.' . $extension;
		$upicture = "../uploads/candidate/" . $pic_rand;

		$noc2_pic = $pic_rand;
		if ($oldpic != "") {
			unlink("../uploads/candidate/" . $oldpic);
		}
		move_uploaded_file($_FILES['oc2_pic']['tmp_name'], $upicture);
	} else {

		$noc2_pic = $oldpic;
	}


	$query = "UPDATE oldcandidate2 SET oc2_name=?, oc2_pic=? WHERE oc2_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssi", $oc2_name, $noc2_pic, $oc2_id);
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

	header("refresh:3; url=deputypresident");
}

// ----------------- Old Candidate 2 -----------------

if (isset($_POST['add2'])) {
	$nc2_name = $_POST['nc2_name'];

	if (isset($_FILES['nc2_pic']['name']) && ($_FILES['nc2_pic']['name'] != "")) {

		$dn = date('ymdHis');
		$nc2_pic = $_FILES['nc2_pic']['name'];
		$extension = pathinfo($nc2_pic, PATHINFO_EXTENSION);
		$randomno = rand(0, 10000);
		$pic_rand = $dn . $randomno . '.' . $extension;
		$upicture = "../uploads/candidate/" . $pic_rand;
	} else {

		$pic_rand = "";
		$upicture = "";
	}

	$result = $conn->query("SELECT MAX(nc2_id) as last_id FROM newcandidate2");
	$row = $result->fetch_assoc();

	if ($row['last_id'] === null) {
		$next_id = 1;
	} else {
		$next_id = $row['last_id'] + 1;
	}

	$query = "INSERT INTO newcandidate2(nc2_id, nc2_name, nc2_pic) VALUES(?,?,?)";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("iss", $next_id, $nc2_name, $pic_rand);
	$stmt->execute();
	move_uploaded_file($_FILES['nc2_pic']['tmp_name'], $upicture);

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

	header("refresh:3; url=deputypresident");
}

if (isset($_GET['delete2'])) {
	$nc2_id = $_GET['delete2'];

	$sql = "SELECT nc2_pic FROM newcandidate2 WHERE nc2_id=?";
	$stmt2 = $conn->prepare($sql);
	$stmt2->bind_param("i", $nc2_id);
	$stmt2->execute();
	$result2 = $stmt2->get_result();
	$row = $result2->fetch_assoc();

	if (!empty($row['nc2_pic'])) { // ถ้ามีชื่อไฟล์
		$imagepath = "../uploads/candidate/" . $row['nc2_pic'];

		if (file_exists($imagepath)) { // ถ้าไฟล์มีจริง
			unlink($imagepath);
		}
	}

	$query = "DELETE FROM newcandidate2 WHERE nc2_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $nc2_id);
	$stmt->execute();

	header("Location: deputypresident");
	exit();
}

if (isset($_POST['update2'])) {
	$nc2_id = $_POST['nc2_id'];
	$nc2_name = $_POST['nc2_name'];
	$oldpic = $_POST['oldpic'];

	if (isset($_FILES['nc2_pic']['name']) && ($_FILES['nc2_pic']['name'] != "")) {
		$dn = date('ymdHis');
		$nc2_pic = $_FILES['nc2_pic']['name'];
		$extension = pathinfo($nc2_pic, PATHINFO_EXTENSION);
		$randomno = rand(0, 10000);
		$pic_rand = $dn . $randomno . '.' . $extension;
		$upicture = "../uploads/candidate/" . $pic_rand;

		$nnc2_pic = $pic_rand;
		if ($oldpic != "") {
			unlink("../uploads/candidate/" . $oldpic);
		}
		move_uploaded_file($_FILES['nc2_pic']['tmp_name'], $upicture);
	} else {

		$nnc2_pic = $oldpic;
	}


	$query = "UPDATE newcandidate2 SET nc2_name=?, nc2_pic=? WHERE nc2_id=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssi", $nc2_name, $nnc2_pic, $nc2_id);
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

	header("refresh:3; url=deputypresident");
}
ob_end_flush();
